<?php

namespace App\Models\Api\V1\Hms;

use App\Jobs\Api\V1\Hms\PriceDetail\SyncPriceDetailJob;
use App\Models\HmsModel;
use Illuminate\Support\Carbon;

class RoomPriceModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_PRICE;
        parent::__construct();
    }
    protected $guarded = [];

    // protected $hidden = [
    //     'created_by','updated_at','updated_by','created_at'
    // ];
    public function saveItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'update-item') {
            //  nếu trung ngày thì tách và tạo mới
            $isOverwrite    = $params['is_overwrite'] ?? false;

            $newStart       = Carbon::parse($params['start_date']);
            $newEnd         = Carbon::parse($params['end_date']);

            $dataInsert = [];

            foreach ($params['price_type'] as $priceTypeId) {
                foreach ($params['room_ids'] as $room_id) {
                    foreach ($params['day_of_week'] as $week => $value) {

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
                            'priceTypeId'   => $priceTypeId ,
                        ];
                        
                        if (self::checkExistItem($dataWhere)) {
                            continue;
                        }
        
                        // Tìm tất cả khoảng bị chồng
                        $overlaps = self::getOverlaps($dataWhere);
        

                        if (!$isOverwrite && $overlaps->isNotEmpty()) {
                            // Trả về các bản ghi bị ghi đè 
                            $results[] = [
                                'room_id'       => $room_id,
                                'price_type_id' => $priceTypeId,
                                'day_of_week'   => $week,
                                'overlaps'      => $overlaps->map->only([
                                    'id', 'room_id', 'price_type_id', 'day_of_week', 'price', 'start_date', 'end_date'
                                ])->toArray()
                            ];
                            continue;
                        }
                
                        // Xử lý ghi đè nếu có quyền
                        // Xử lý chồng lặp
                        
                        $rowInsert  = [
                            'room_id'       => $room_id,
                            'day_of_week'   => $week,
                            'price_type_id' => $priceTypeId,
                            'is_active'     => true,
                            'created_by'    => auth('hms')->id(),
                            'created_at'    => date('Y-m-d H:i:s'),
                        ];

                        foreach ($overlaps as $old) {
                            $oldStart       = Carbon::parse($old->start_date);
                            $oldEnd         = Carbon::parse($old->end_date);
                            $old->is_active = false;
                            $old->save();
        
                            // Giữ phần trước
                            if ($oldStart < $newStart) {
                                $dataInsert[] = [
                                    ...$rowInsert,
                                    'price'       => $old->price,
                                    'start_date'  => $oldStart->toDateString(),
                                    'end_date'    => $newStart->copy()->subDay()->toDateString(),
                                    'type'        => 'split'
                                ];
                               
                            }
        
                            // Giữ phần sau
                            if ($oldEnd > $newEnd) {
                                $dataInsert[] = [
                                    ...$rowInsert,
                                    'price'       => $old->price,
                                    'start_date'  => $newEnd->copy()->addDay()->toDateString(),
                                    'end_date'    => $oldEnd->toDateString(),
                                    'type'        => 'split'
                                ];
                            }
                        }
        
                        // Thêm khoảng mới
                        $dataInsert[] = [
                            ...$rowInsert,
                            'price'       => $value,
                            'start_date'  => $newStart->toDateString(),
                            'end_date'    => $newEnd->toDateString(),
                            'type'        => 'setup'
                        ];
                        
                        
                    }
                }
            }
            if(count($dataInsert) > 0 ){
                self::insert($dataInsert);

                // thêm vào bảng chi tiết room_price_detail
                $user_id = auth('hms')->id();
                // SyncPriceDetailJob::dispatch($dataInsert, $isOverwrite,$user_id);
                PriceDetailModel::syncPriceDetail($dataInsert, $isOverwrite,$user_id);
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
                        'price'         => $data['value'],
                        'is_active'     => true,
                        'price_type_id' => $data['priceTypeId']
                    ])
                ->exists();
    }

    public function getOverlaps($data){
        return self::where(
                [
                    'room_id'           => $data['room_id'],
                    'price_type_id'     => $data['priceTypeId'],
                    'day_of_week'       => $data['week'],
                    'is_active'         => true
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
   


    public function priceType()
    {
        return $this->belongsTo(PriceTypeModel::class, 'price_type_id','id');
    }
    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id','id');
    }
     public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-history') {
           $query       = self::with('created_by:id,full_name','priceType:id,name','room:id,name,name_id')
                        ->where('type','setup')
                        ->whereHas('room',function ($q) {
                            $q->where('hotel_id',auth('hms')->user()->current_hotel_id);
                        });
            
            $results    = $query->orderBy('created_at','desc')
                        ->paginate($params['limit'] ?? 20);
        }
        return $results;
    }
    public function created_by() {
        return $this->belongsTo(CustomerModel::class,'created_by','id');
    }
}
