<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PriceSettingModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_SETTING;
        $this->hidden       = ['status','created_at','created_by'];
        $this->appends      = [];
    }
}