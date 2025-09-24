<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class RoomNameModel extends AdminModel
{

    public $crudNotAccepted = [];
    public function __construct($attributes = [])
    {
        $this->attributes       = $attributes;
        $this->table            = TABLE_HOTEL_ROOM_NAME;

        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $data           = [];

            foreach ($params as $key => $value) {
                if(!empty($value)){
                    $data[]     = [
                        'name'          => $value,
                        'slug'          => Str::slug($value),
                        'status'        => 'active',
                        'created_by'    =>  Auth::user()->id,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'room_type_id'  => $options['insert_id']
                    ];
                }
            }

            self::insert($data);

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') {

            $ids            = [];
            if(count($params) > 0){
                foreach ($params as $key => $value) {
                    $ids[]      = $key;
                    self::where('id',$key)->update([
                        'name'          => $value,
                        'slug'          => Str::slug($value),
                        'status'        => 'active',
                        'updated_by'    =>  Auth::user()->id,
                        'updated_at'    =>  date('Y-m-d H:i:s'),
                        'room_type_id'  => $options['insert_id']
                    ]);
                }
            }
            self::deleteItem($ids,[...$options,'task' => 'delete-item']);
            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }

    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if(count($params ?? []) > 0){
                self::whereNotIn('id',$params)->where('room_type_id',$options['insert_id'])->delete();
            }
        }
    }
}
