<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PolicyGeneralModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POLICY_GENERAL;
        parent::__construct();
    }
    
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $limit      = $params['limit'] ?? 1000;

            $results    = PolicySettingModel::select('id','name')->with(['policyGeneral'=>function($query)use($hotel_id){
                                $query->select('is_allow','policy_setting_id')->where('hotel_id',$hotel_id);
                            }])
                        ->where(['status'=>'active','type' => 'general'])
                        ->limit($limit)->get();
        }
        return $results;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'edit-item') {
            $hotel_id = auth('hms')->user()->current_hotel_id;

            $data = $params['policies'];
            $ids  = array_map(fn($item)=> $item['policy_setting_id'],$data);
            
            self::where('hotel_id', $hotel_id)
            ->whereNotIn('policy_setting_id', $ids)
            ->delete();

            foreach ($data ?? [] as $key => $value) {
                self::updateOrInsert(
                    [
                        'hotel_id'          => $hotel_id,
                        'policy_setting_id' => $value['policy_setting_id']
                    ],[
                        'hotel_id'          => $hotel_id,
                        'policy_setting_id' => $value['policy_setting_id'],
                        'is_allow'          => $value['is_allow'] ?? false
                    ]
                );
            }
        }

    }
    public function getItem($params = null, $options = null){
        if ($options['task'] == 'item-info') {

            $hotel_id = auth('hms')->user()->current_hotel_id;

            return self::select('policy_setting_id','is_allow')->where(['hotel_id'=>$hotel_id])->get();
        }

    }
    public function policy_name(){
        return $this->belongsTo(PolicySettingModel::class,'policy_setting_id','id')->select('id','name');
    }
}
