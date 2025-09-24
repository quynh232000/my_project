<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class BookingDailyPriceModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_BOOKING_DAILY_PRICE;
        $this->hidden   = ['created_at','updated_at','created_by','deleted_at'];
        $this->appends  = [];

        parent::__construct();
    }
    protected $casts    =  [
                            'promotions' => 'array'
                        ]; 
}
