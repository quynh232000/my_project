<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class RoomModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_ROOM;
        $this->hidden   = ['created_at','created_by','updated_at','updated_by','status'];
        $this->appends  = [];
    }
    public function price_details()
    {
        return $this->hasMany(PriceDetailModel::class, 'room_id', 'id');
    }
    public function price_settings()
    {
        return $this->hasMany(PriceSettingModel::class, 'room_id', 'id')->where('status', 'active');
    }
    public function scopeAvailableRoom($query, $params)
    {
        return $query
                ->where('status', 'active')
                ->when($params['capacity'] ?? null,  fn ($q) => $q->whereRaw('max_capacity * ? >= ?', [$params['quantity'], $params['adt'] + $params['chd']]))
                ->when($params['adt']     ?? null,  fn ($q) => $q->whereRaw('(standard_guests + max_extra_adults) * ? >= ?', [$params['quantity'], $params['adt']]))
                ->when($params['chd']     ?? null,  fn ($q) => $q->whereRaw('(standard_guests + max_extra_children) * ? >= ?', [$params['quantity'], $params['chd']]));
    }
    public function amenities(){
        return $this->belongsToMany(ServiceModel::class,TABLE_HOTEL_HOTEL_SERVICE,'point_id','service_id')->where(TABLE_HOTEL_HOTEL_SERVICE.'.type','room');
    }
    public function images()
    {
        return $this->hasMany(AlbumModel::class, 'point_id', 'id')->where('type', 'room_type')->orderBy('priority','asc');
    }
    public function promotions(){
        return $this->belongsToMany(PromotionModel::class,PromotionRoomModel::class,'room_id','promotion_id');
    }
    public function room_extra_beds(){
        return $this->hasMany(RoomExtraBedModel::class,'room_id','id');
    }
    public function bed_type(){
        return $this->belongsTo(AttributeModel::class,'bed_type_id','id');
    }
    public function sub_bed_type(){
        return $this->belongsTo(AttributeModel::class,'sub_bed_type_id','id');
    }
    public function hotel(){
        return $this->belongsTo(HotelModel::class,'hotel_id','id');
    }
    public function direction(){
        return $this->belongsTo(AttributeModel::class,'direction_id','id');
    }

    
}
