<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PriorityModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRIORITY;
        $this->hidden       = [];
        $this->appends      = [];
    }
}
