<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PriceDetailPriceTypeModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_DETAIL_PRICE_TYPE;
        parent::__construct();
    }
    protected $fillable = ['price_detail_id', 'price_type_id', 'price'];
}
