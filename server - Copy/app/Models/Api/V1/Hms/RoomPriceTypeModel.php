<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class RoomPriceTypeModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_PRICE_TYPE;
        parent::__construct();
    }
    
    protected $guarded      = [];
  
    public function saveItem($params = null, $options = null)
    {
        $results            = null;
        if ($options['task'] == 'update-item') {
            foreach ($params as  $value) {
                self::updateOrInsert([
                    'room_price_id' => $options['insert_id'],
                    'price_type_id'     => $value == 'standard' ? null : $value
                ],[
                    'room_price_id' => $options['insert_id'],
                    'price_type_id'     => $value == 'standard' ? null : $value
                ]);
            }
            $ids = array_values(array_filter($params, fn($item) => $item !== 'standard')) ?? [];
            self::where('room_price_id',$options['insert_id'])->whereNotIn('price_type_id',$ids)->delete();
  
        }
        
        return $results;
    }
    public function price_type()
    {
        return $this->belongsTo(PriceTypeModel::class,'price_type_id','id');
    }
    public function price_room() {
        return $this->belongsTo(RoomPriceModel::class,'room_price_id','id');
    }
  
}
