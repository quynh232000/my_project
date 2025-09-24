<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;

class PromotionRoomTypeModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PROMOTION_ROOM_TYPE;

        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới
            if ($params['all_room_types'] != 0) {
                $this->roomType            = new RoomTypeModel();
                $params['room_types']      = $this->roomType->getItem($params, ['task'=>'get-room-type'])->pluck('id')->toArray();
            }
            $dataRoomTypes = array_map(fn($value) => ['promotion_id' => $params['inserted_id'], 'room_type_id' => $value], $params['room_types']);
            self::insert($this->prepareParams($dataRoomTypes));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') {
            if ($params['all_room_types'] != 0) {
                $this->roomType           = new RoomTypeModel();
                $params['room_types']      = $this->roomType->getItem($params, ['task'=>'get-room-type'])->pluck('id')->toArray();
            }
            $list_room_type    = self::where($this->table . '.promotion_id', $params['id'])->get()->pluck('room_type_id')->toArray();
            $toDelete          = array_diff($list_room_type, $params['room_types']);
            $toAdd             = array_diff($params['room_types'], $list_room_type);
            $data_room_types   = array_map(fn($value) => ['promotion_id' => $params['inserted_id'], 'room_type_id' => $value], $toAdd);
            $this->whereIn($this->table . '.room_type_id', $toDelete)->delete();
            $this->insert($this->prepareParams($data_room_types));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {

                self::whereIn($this->table . '.promotion_id', $params['id'])->delete();
            }
        }
    }
}
