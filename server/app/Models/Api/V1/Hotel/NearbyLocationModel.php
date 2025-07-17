<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class NearbyLocationModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_NEARBY_LOCATION;
        $this->hidden       = [];
        $this->appends      = [];
    }
}
