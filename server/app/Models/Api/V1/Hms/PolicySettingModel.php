<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PolicySettingModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POLICY_SETTING;
        parent::__construct();
    }
  
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $limit      = $params['limit'] ?? 1000;
            $type       = isset($params['type']) && $params['type'] == 'other' ? 'other' : 'general';
            
            $results    = self::select('id','name')
                        ->where(['type' => $type,'status' => 'active'])
                        ->limit($limit)
                        ->get();
        }
        return $results;
    }
    public function policyGeneral()  {
        return $this->hasOne(PolicyGeneralModel::class,'policy_setting_id','id');
    }
    public function policy_other(){
        return $this->hasOne(PolicyOtherModel::class,'policy_setting_id','id');
    }
}
