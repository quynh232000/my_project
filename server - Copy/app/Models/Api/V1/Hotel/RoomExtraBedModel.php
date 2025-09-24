<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class RoomExtraBedModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_ROOM_EXTRA_BED;
        $this->hidden   = ['created_at','updated_at','created_by','deleted_at'];
        $this->appends  = [];

        parent::__construct();
    }
}
