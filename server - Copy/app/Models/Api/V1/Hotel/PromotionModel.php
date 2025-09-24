<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PromotionModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_PROMOTION;
        $this->hidden   = ['created_at','created_by','updated_at','updated_by'];
        $this->appends  = [];

        parent::__construct();
    }
    public function rooms(){
        return $this->belongsToMany(RoomModel::class,PromotionRoomModel::class,'promotion_id','room_id');
    }
    public function price_types(){
        return $this->belongsToMany(PriceTypeModel::class,PromotionPriceTypeModel::class,'promotion_id','price_type_id');
    }
}
