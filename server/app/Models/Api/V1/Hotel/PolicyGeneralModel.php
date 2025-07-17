<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PolicyGeneralModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_POLICY_GENERAL;
        $this->hidden   = ['created_at','updated_at'];
        $this->appends  = [];

        parent::__construct();
    }

    public function policy_name(){
        return $this->belongsTo(PolicySettingModel::class,'policy_setting_id','id')->select('id','name');
    }

}
