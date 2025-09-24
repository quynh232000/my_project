<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class AttributeModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ATTRIBUTE;
        $this->hidden       = [];
        $this->appends      = [];
    }
    public function parents()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function hotels() {
        return $this->hasMany(HotelModel::class,'accommodation_id','id');
    }
}
