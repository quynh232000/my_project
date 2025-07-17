<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoomPriceTypeModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_PRICE_TYPE;
        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới

            $params['created_by']       = Auth::user()->id;
            $params['created_at']       = date('Y-m-d H:i:s');
            if (isset($params['all_room_types']) != 0) {
                $this->roomType         = new RoomTypeModel();
                $params['room_type_id']   = $this->roomType->getItem($params, ['task'=>'get-room-type'])->pluck('id')->toArray();
            }
            $room_price_types   = array_map(fn($value) => [
                'price_type_id' => $params['inserted_id'],
                'room_type_id'  => $value
            ],
                $params['room_type_id']);
            self::insert($this->prepareParams($room_price_types));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            if (isset($params['all_room_types']) != 0) {
                $this->roomType              = new RoomTypeModel();
                $params['room_type_id']      = $this->roomType->getItem($params, ['task'=>'get-room-type'])->pluck('id')->toArray();
            }
            $list_room_type     = self::where($this->table . '.price_type_id', $params['id'])->get()->pluck('room_type_id')->toArray();
            $toAdd              = array_diff($params['room_type_id'], $list_room_type);
            $room_price_types   = array_map(fn($value) => ['price_type_id' => $params['inserted_id'], 'room_type_id' => $value], $toAdd);
            self::where($this->table . '.price_type_id', $params['id'])->whereNotIn($this->table . '.room_type_id', $params['room_type_id'])->delete();
            $this->insert($this->prepareParams($room_price_types));
            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {

                self::whereIn($this->table . '.price_type_id', $params['id'])->delete();
            }
        }
    }
}
