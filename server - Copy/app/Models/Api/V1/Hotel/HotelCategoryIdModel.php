<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class HotelCategoryIdModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_CATEGORY_ID;
        $this->hidden       = [];
    }
}
