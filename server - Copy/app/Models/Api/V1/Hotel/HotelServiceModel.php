<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;
use Kalnoy\Nestedset\NodeTrait;

class HotelServiceModel extends ApiModel
{
    use NodeTrait;
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_SERVICE;
        $this->hidden       = [];
        $this->appends      = [];
    }
    public function facility()
    {
        return $this->belongsTo(ServiceModel::class, 'service_id', 'id');
    }
    public function amenity()
    {
        return $this->belongsTo(ServiceModel::class, 'service_id', 'id');
    }
    public function hotel()
    {
        return $this->belongsTo(HotelModel::class, 'point_id', 'id');
    }
    public function room()
    {
        return $this->hasOne(RoomModel::class, 'id', 'point_id');
    }
    public function parents()
    {
        return $this->belongsTo(HotelServiceModel::class, 'parent_id', 'id');
    }
}
