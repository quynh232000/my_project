<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PromotionRoomModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_PROMOTION_ROOM;
        $this->hidden   = [];
        $this->appends  = [];

        parent::__construct();
    }

}
