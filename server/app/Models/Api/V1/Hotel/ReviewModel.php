<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class ReviewModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_REVIEW;
        $this->hidden       = ['updated_by','updated_at','created_by','deleted_at'];
        $this->appends      = [];
    }
    public $data = [
        'type'      => ['Kỳ nghỉ ngắn', 'Nghỉ dưỡng', 'Công tác', 'Kỳ nghỉ gia đình', 'Du lịch',],
        'quality'   => [
            0 =>  'Sạch sẽ',
            1 =>  'Thoải mái',
            2 =>  'Đồ ăn',
            3 =>  'Vị trí',
            4 =>  'Giá cả',
        ],
    ];
    public function getImageAttribute()
    {        
        return $this->attributes['image'] ? URL_DATA_IMAGE.'hotel/review/images/'. $this->id . "/" . $this->attributes['image'] : null;
    }
    public function getTypeAttribute()
    {        
        return $this->attributes['type'] ? json_decode($this->attributes['type']) : null;
    }
    public function getQualitiesAttribute()
    {        
        $data = $this->attributes['qualities'] ? json_decode($this->attributes['qualities'],true) : [];
        $data = array_map(fn($i)=>[...$i,'quality' => $this->data['quality'][$i['quality']]],$data);
        return $data;
    }
    public function images(){
        return $this->hasMany(ReviewImageModel::class,'hotel_review_id','id');
    }
}
