<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;

class ReviewImageModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_REVIEW_IMAGE;
        $this->hidden   = ['created_at', 'updated_at', 'created_by', 'deleted_at'];
        $this->appends  = [];

        parent::__construct();
    }
    // public function getImageAttribute()
    // {
    //     return $this->attributes['image'] ? URL_DATA_IMAGE.'hotel/review/images/'. $this->hotel_review_id . "/" . $this->attributes['image'] : null;
    // }
}
