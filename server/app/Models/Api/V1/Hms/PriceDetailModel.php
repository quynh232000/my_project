<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Illuminate\Support\Carbon;
class PriceDetailModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_DETAIL;
        parent::__construct();
    }
   
    public static function syncPriceDetail(array $dataInsert, bool $isOverwrite = true,$user_id)
    {

        $priceDetails       = [];
        $priceTypeDetails   = [];

        foreach ($dataInsert as $item) {
            $start          = Carbon::parse($item['start_date']);
            $end            = Carbon::parse($item['end_date']);
            $dayOfWeek      = (int) $item['day_of_week'];

            while ($start->lte($end)) {
                if ((int) $start->isoWeekday() === $dayOfWeek) {
                    $dateStr            = $start->toDateString();

                    // Tạo dữ liệu cho bảng price_detail
                    $priceDetailKey     = $item['room_id'] . '_' . $dateStr;

                    $priceDetails[$priceDetailKey] = [
                        'room_id'       => $item['room_id'],
                        'date'          => $dateStr,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'created_by'    => $user_id
                    ];

                    // Chỉ thêm nếu tồn tại
                    $optionalFields     = ['quantity', 'status'];

                    foreach ($optionalFields as $field) {
                        if (array_key_exists($field, $item)) {//nếu có status thì thêm status|| quantity
                            $priceDetails[$priceDetailKey][$field] = $item[$field];
                        }
                    }

                    // Chuẩn bị dữ liệu price_type nếu có
                    if (isset($item['price_type_id'], $item['price'])) {
                        $priceTypeDetails[] = [
                            'room_id'        => $item['room_id'],
                            'date'           => $dateStr,
                            'price_type_id'  => (int) $item['price_type_id'],
                            'price'          => $item['price']
                        ];
                    }
                }
                $start->addDay();
            }
        }

        // Upsert price_detail
        if (!empty($priceDetails)) {
            $upsertData     = array_values($priceDetails);

            $updateColumns  = [];

            if ($isOverwrite) {
                // Xác định các field thực sự có trong dữ liệu status | quantity
                $allKeys    = collect($upsertData)
                            ->flatMap(fn($row) => array_keys($row))
                            ->unique()
                            ->toArray();

                $possibleUpdates = ['quantity', 'status'];
                $updateColumns = array_values(array_intersect($possibleUpdates, $allKeys));
            }
            self::upsert(
                $upsertData,
                ['room_id', 'date'],
                ['room_id', 'date',...$updateColumns]
            );
            // if(!empty($updateColumns)){
            // }
        }

        // Gắn price_detail_id vào price_detail_price_type
        if (!empty($priceTypeDetails)) {
            // 1. Tạo map: room_id + date => id
            $roomDatePairs = collect($priceTypeDetails)
                            ->map(fn($row) => [$row['room_id'], $row['date']])
                            ->unique()
                            ->values()
                            ->all();

            $priceDetailMap = self::whereIn('room_id', array_unique(array_column($roomDatePairs, 0)))
                            ->whereIn('date', array_unique(array_column($roomDatePairs, 1)))
                            ->select('id', 'room_id', 'date')
                            ->get()
                            ->keyBy(fn($row) => $row->room_id . '_' . $row->date);
            // 2. Lặp và gắn price_detail_id
            foreach (collect($priceTypeDetails)->chunk(500) as $chunk) {
                $chunkWithDetailId              = [];

                foreach ($chunk as $row) {
                    $key                        = $row['room_id'] . '_' . $row['date'];
                    if (isset($priceDetailMap[$key])) {
                        $chunkWithDetailId[]    = [
                                                    'price_detail_id' => $priceDetailMap[$key]->id,
                                                    'price_type_id'   => $row['price_type_id'],
                                                    'price'           => $row['price'],
                                                    'room_id'         => $row['room_id']
                                                ];
                    }
                }

                if (!empty($chunkWithDetailId)) {
                    PriceDetailPriceTypeModel::upsert(
                        $chunkWithDetailId,
                        ['price_detail_id', 'price_type_id'],
                        ['price_detail_id', 'price_type_id','price','room_id']
                    );
                }
            }
        }
    }

}
