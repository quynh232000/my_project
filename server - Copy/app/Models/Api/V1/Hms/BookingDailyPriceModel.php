<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class BookingDailyPriceModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BOOKING_DAILY_PRICE;
        parent::__construct();
    }
    protected $casts        = [
                                'promotions' => 'array'
                            ]; 
    protected $hidden       = [
                                'created_by','created_at','updated_at','updated_by','ip'
                            ];
}
