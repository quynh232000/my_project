<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PriceDetailPriceTypeModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_DETAIL_PRICE_TYPE;
        $this->hidden       = [];
        $this->appends      = [];
    }
    public function price_type(){
        return $this->belongsTo(PriceTypeModel::class,'price_type_id','id');
    }
}
