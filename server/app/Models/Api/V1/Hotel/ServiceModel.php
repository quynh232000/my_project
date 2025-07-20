<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;
use Kalnoy\Nestedset\NodeTrait;

class ServiceModel extends ApiModel
{
    use NodeTrait;
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_SERVICE;
        $this->hidden       = [];
        $this->appends      = [];
    }
    // public function getImageAttribute()
    // {
    //     return $this->attributes['image'] ? URL_DATA_IMAGE.'hotel/service/images/'. $this->id . "/" . $this->attributes['image'] : null;
    // }
}
