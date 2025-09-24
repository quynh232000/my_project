<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PriceSettingModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_SETTING;
        parent::__construct();
    }
       protected $guarded = [];
    // public $crudNotAccepted = ["room_type"];
    protected $hidden = [
        'created_by','updated_at','updated_by','created_at'
    ];

  
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'update-item') {

            foreach ($params['data'] as $item) {
                self::updateOrCreate([
                    'room_id'           => $params['room_id'],
                    'price_type_id'     => $params['price_type_id'] ?? null,
                    'capacity'          => $item['capacity'],
                ],[
                    'room_id'           => $params['room_id'],
                    'price_type_id'     => $params['price_type_id'] ?? null,
                    'capacity'          => $item['capacity'],
                    'price'             => $item['price'],
                    'status'            => $item['status'],
                    "created_by"        => auth('hms')->id()
                ]);
            }
        }
        
        return $results;
    }


}
