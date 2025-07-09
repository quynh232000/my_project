<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PolicyCancellationModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_POLICY_CANCELLATION;
        $this->hidden   = ['created_at','updated_at','created_by','deleted_at','status'];
        $this->appends  = [];

        parent::__construct();
    }
    public function policy_cancel_rules(){
        return $this->hasMany(PolicyCancelRuleModel::class,'policy_cancel_id','id');
    }
    public function price_types(){
        return $this->hasMany(PriceTypeModel::class,'policy_cancel_id','id');
    }
}
