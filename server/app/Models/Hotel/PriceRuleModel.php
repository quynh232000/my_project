<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;
class PriceRuleModel extends AdminModel
{
    public function __construct()
    {
        $this->table            = TABLE_HOTEL_PRICE_RULE;
        parent::__construct();
    }
    public function saveItem($params = null, $options = null){
        $this->roomType                     = new RoomTypeModel();
        if ($options['task'] == 'add-item') {
            $result = [];
            if (isset($params['all_room_types']) && $params['all_room_types'] != 0) {
                $params['room_type_id']     = $this->roomType->getItem($params, ['task' => 'get-room-type'])->pluck('id')->toArray();
                $check_room_type            = self::whereIn('room_type_id', $params['room_type_id'])
                                                ->whereIn('price_type_id', [$params['inserted_id']])->get();
            } else {
                $check_room_type            = self::whereIn('room_type_id', $params['room_type_id'])
                                                ->whereIn('price_type_id', [$params['inserted_id']])->get();
            }
            $existingRoomTypeIds            = $check_room_type->pluck('room_type_id')->toArray();
            $params['room_type_ids']        = array_diff($params['room_type_id'], $existingRoomTypeIds);

            foreach($params['room_type_ids'] as $params['id']){
                $params['room_type']        =   $this->roomType->getItem($params, ['task' => 'get-item-info']);
                $standard_capacity          =   $params['room_type']['standard_capacity'];
                $max_capacity               =   $params['room_type']['max_capacity'];
                for ($capacity = 1; $capacity <= $max_capacity; $capacity++) {
                    $type = $capacity > $standard_capacity ? 'increase' : ($capacity < $standard_capacity ? 'decrease' : 'default');
                    $result[] = [
                        'room_type_id'      =>  $params['room_type']['id'],
                        'price_type_id'     =>  $params['inserted_id'],
                        'capacity'          =>  $capacity,
                        // 'standard_price'    =>  $params['room_type']['price_standard'],
                        'type'              =>  $type,
                        'created_by'        =>  Auth::user()->id,
                        'created_at'        =>  date('Y-m-d H:i:s'),
                    ];
                }
            }
            self::insert($this->prepareParams($result));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') {
            $result = [];
            foreach ($params['rules'] as $room_type_id => $price_types) {
                foreach ($price_types as $price_type_id => $details) {
                    foreach ($details['capacity'] as $index => $capacity) {
                        if ($details['price'][$index] || $details['price'][$index]) {
                            $result[] = [
                                'room_type_id'  => $room_type_id,
                                'price_type_id' => $price_type_id,
                                'capacity'      => $capacity,
                                'type'          => $details['type'][$index],
                                'price_standard' => $details['price_standard'],
                                'price'         => $this->unformatNumber($details['price'][$index] ?? null),
                                'status'        => 'active'
                            ];
                        }

                        self::where([
                            ['room_type_id',    '=', $room_type_id],
                            ['price_type_id',   '=', $price_type_id],
                            ['capacity',        '=', $capacity]
                        ])->update([
                            'price'     => $this->unformatNumber($details['price'][$index] ?? null),
                            'status'    => $details['price'][$index] ? 'active' : 'inactive'
                        ]);
                    }
                }
            }

            $this->dateBasesPrice       = new DateBasedPriceModel();
            $this->dateBasesPrice->saveItem($result, ['task' => 'edit-capacity-price']);
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
    }
    protected function unformatNumber($value)
    {
        return str_replace('.', '', $value);
    }

}
