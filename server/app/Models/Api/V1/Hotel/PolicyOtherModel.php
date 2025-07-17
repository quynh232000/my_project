<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PolicyOtherModel extends ApiModel
{
    public function __construct()
    {
        $this->table = TABLE_HOTEL_POLICY_OTHER;

        parent::__construct();
        $this->hidden        = ['created_at','created_by'];
        $this->appends       = [];
    }
    protected $casts = [
        'settings' => 'array'
    ];
    public function policy_name(){
        return $this->belongsTo(PolicySettingModel::class,'policy_setting_id','id')->select('id','name');
    }

}
