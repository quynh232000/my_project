<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Illuminate\Support\Facades\Storage;

class BookingBillingModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BOOKING_BILLING;
        parent::__construct();
    }
    protected $casts        = [
                              
                            ]; 
    protected $hidden       = [
                                'created_by','created_at','updated_at','updated_by','ip'
                            ];
}
