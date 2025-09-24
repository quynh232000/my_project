<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PolicySettingModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_POLICY_SETTING;
        $this->hidden   = ['created_at','updated_at'];
        $this->appends  = [];

        parent::__construct();
    }

}
