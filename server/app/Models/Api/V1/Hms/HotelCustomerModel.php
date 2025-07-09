<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class HotelCustomerModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_CUSTOMER;
        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'edit-item') {
            $hotel_id   = auth('hms')->user()->current_hotel_id;

           self::updateOrInsert([
                                                'hotel_id'      =>$hotel_id,
                                                'customer_id'   => $params['insert_id'],
                                                // 'role'          => $params['role'],
                                            ],
                                    [
                                                'hotel_id'      =>$hotel_id,
                                                'customer_id'   => $params['insert_id'],
                                                'status'        => 'active',
                                                'role'          => $params['role'],
                                                'created_at'    => date('Y-m-d H:i:s'),
                                            ]
                                        );
        }
        return $results;
    }
}
