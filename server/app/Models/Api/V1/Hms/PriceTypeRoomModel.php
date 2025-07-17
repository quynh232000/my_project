<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PriceTypeRoomModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_TYPE_ROOM;
        parent::__construct();
    }

    protected $guarded = [];
  
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'detail') {
            
        }
        
        return $results;
    }
  
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $data = [];
            foreach ($params as $key => $value) {
                $data[$key]['price_type_id']  = $options['price_type_id'];
                $data[$key]['room_id']   = $value;
            }  
            self::insert($data);
        }

        if ($options['task'] == 'edit-item') {
            $oldIds = self::where(['price_type_id' => $options['price_type_id']])->pluck('room_id')->all();

            $insertIds = array_diff($params,$oldIds);
            $deleteIds = array_diff($oldIds,$params);
            if(count($insertIds) > 0 ){
                self::saveItem($insertIds,[...$options,'task' => 'add-item']);
            }
            if(count($deleteIds) > 0){
                self::deleteItem($deleteIds,[...$options,'task' => 'delete-item']);
            }
        }
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-all') {
            self::where('price_type_id',$params['id'])->delete();
        }

        if ($options['task'] == 'delete-item') {
            self::where('price_type_id',$options['price_type_id'])->whereIn('room_id',$params)->delete();
        }
    }
    public function roomType() {
        return $this->belongsTo(AttributeModel::class,'room_id','id');
    }
  

}
