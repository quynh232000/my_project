<?php

namespace App\Models\Api\V1\Hms;

use App\Jobs\Api\V1\Hms\PriceDetail\SyncPriceDetailJob;
use App\Models\HmsModel;
use Illuminate\Support\Carbon;

class RoomStatusModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_STATUS;
        parent::__construct();
    }
    protected $guarded      = [];
    protected $hidden = [
        'created_by','updated_at','updated_by','created_at'
    ];
    public function saveItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'update-item') {

            $dataInsert = [];

            //  nếu trung ngày thì tách và tạo mới

            $newStart   = Carbon::parse($params['start_date']);
            $newEnd     = Carbon::parse($params['end_date']);
            foreach ($params['room_ids'] as $room_id) {
                foreach ($params['day_of_week'] as $week => $value) {
                    if (empty($value)) {
                        continue;
                    }

                    // nếu ngày trong tuần không tồn tại trong khoảng ngày đó 
                    if (!self::hasMatchingWeekday($newStart->copy(), $newEnd->copy(), (int)$week)) {
                        continue;
                    }

                    // Check duplicate: nếu có bản ghi y chang thì bỏ qua
                    $dataWhere = [
                        'room_id'       => $room_id,
                        'week'          => $week ,
                        'newStart'      => $newStart ,
                        'newEnd'        => $newEnd ,
                        'value'         => $value ,
                    ];

                    if (self::checkExistItem($dataWhere)) {
                        continue;
                    }
    
                    // Tìm tất cả khoảng bị chồng
                    $overlaps = self::getOverlaps($dataWhere);
    
                    // Xử lý chồng lặp
                    
                    $rowInsert  = [
                        'room_id'       => $room_id,
                        'day_of_week'   => $week,
                        'created_by'    => auth('hms')->id(),
                        'created_at'    => date('Y-m-d H:i:s'),
                    ];

                    foreach ($overlaps as $old) {
                        $oldStart       = Carbon::parse($old->start_date);
                        $oldEnd         = Carbon::parse($old->end_date);
                        $old->delete();
    
                        // Giữ phần trước
                        if ($oldStart < $newStart) {
                            $dataInsert[] = [
                                ...$rowInsert,
                                'status'      => $old->status,
                                'start_date'  => $oldStart->toDateString(),
                                'end_date'    => $newStart->copy()->subDay()->toDateString(),
                            ];
                        }
    
                        // Giữ phần sau
                        if ($oldEnd > $newEnd) {
                            $dataInsert[] = [
                                ...$rowInsert,
                                'status'      => $old->status,
                                'start_date'  => $newEnd->copy()->addDay()->toDateString(),
                                'end_date'    => $oldEnd->toDateString(),
                            ];
                        }
                    }
    
                    // Thêm khoảng mới
                    $dataInsert[] = [
                        ...$rowInsert,
                        'status'        => $value,
                        'start_date'    => $newStart->toDateString(),
                        'end_date'      => $newEnd->toDateString(),
                    ];

                }
            }

            if(count($dataInsert) > 0 ){
                self::insert($dataInsert);
                
                $user_id = auth('hms')->id(); 
                // thêm vào bảng chi tiết price_detail
                // SyncPriceDetailJob::dispatch($dataInsert, true,$user_id);
                PriceDetailModel::syncPriceDetail($dataInsert, true,$user_id);
            }
        }
        
        return $results;
    }

    public function checkExistItem($data) {
        return  self::where(
            [
                        'room_id'       => $data['room_id'],
                        'day_of_week'   => $data['week'],
                        'start_date'    => $data['newStart']->toDateString(),
                        'end_date'      => $data['newEnd']->toDateString(),
                        'status'        => $data['value']
                    ])
                ->exists();
    }

    public function getOverlaps($data){
        return self::where(
                [
                    'room_id'           => $data['room_id'],
                    'day_of_week'       => $data['week'],
                ])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_date', [$data['newStart'], $data['newEnd']])
                        ->orWhereBetween('end_date', [$data['newStart'], $data['newEnd']])
                        ->orWhere(function ($q) use ($data) {
                            $q->where('start_date', '<=', $data['newStart'])
                                ->where('end_date', '>=', $data['newEnd']);
                        });
                })
                ->get();
    }
    public function hasMatchingWeekday(Carbon $start, Carbon $end, int $weekday): bool
    {

        while ($start->lte($end)) {
            if ($start->isoWeekday() === $weekday) {
                return true;
            }
            $start->addDay();
        }
        return false;
    }

}
