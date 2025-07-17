<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PolicyOtherModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POLICY_OTHER;
        parent::__construct();
    }
    // protected $guarded      = [];
    protected $hidden       = ['created_at', 'created_by', 'updated_at'];

    // public $crudNotAccepted = ['is_allow'];
    protected $fillable     = [
        'hotel_id','policy_setting_id','settings','created_by'
    ];
    protected $casts = [
        'settings' => 'array',
    ];
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;

            $results    = PolicySettingModel::select('id','name','slug')
                            ->where(['status' => 'active','type' => 'other'])
                            ->with(['policy_other' => function ($q) use($hotel_id) {
                                $q->select('id', 'policy_setting_id', 'hotel_id')
                                ->where('hotel_id', $hotel_id);
                            }])
                            ->get()
                            ->map(function ($item) {
                                if($item->policy_other){
                                    $item->is_active = true;
                                }else{
                                    $item->is_active = false;
                                }
                                unset($item->policy_other);
                                return $item;
                            })
                            ->values();
        }
        return $results;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'edit-item') {

            $params['hotel_id']   = auth('hms')->user()->current_hotel_id;

            $params['policy_id']     = PolicySettingModel::select('id')->where('slug',$params['slug'])->pluck('id')->first();

            if(isset($params['is_active']) && $params['is_active'] == false){

                self::where([
                    'policy_setting_id'     => $params['policy_id'],
                    'hotel_id'              => $params['hotel_id']
                ])->delete();

            }else{

                $params['created_by']       = auth('hms')->id();
                $params['created_at']       = date('Y-m-d H:i:s');
    
                self::updateOrCreate(
                    [
                        'policy_setting_id' => $params['policy_id'],
                        'hotel_id'          => $params['hotel_id']
                    ],
                    $this->prepareParams($params)
                );
                
            }
            
            return [
                'status'    => true,
                'message'   => 'Cập nhật thành công!'
            ];

        }

    }
    public function getItem($params = null, $options = null){

        $result = null;
        if ($options['task'] == 'item-info') {
            // dd($params);
            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $result     = self::with('policy:id,name,slug')
                            ->where(['hotel_id' => $hotel_id])
                            ->whereHas('policy',function ($q) use($params) {
                                $q->where('slug',$params['slug']);
                            })
                            ->first();
        }
        if($result){
            return [
                'is_active' => true,
                ...$result->toArray()
            ];
        }
        return [
            'is_active'     => false
        ];
    }
    public function deleteItem($id, $options = null){
        if ($options['task'] == 'delete-item') {
            
            $hotel_id = auth('hms')->user()->current_hotel_id;
            self::where(['hotel_id'=>$hotel_id,'id'=>$id])->delete();
        }
    }
    public function policy(){
        return $this->belongsTo(PolicySettingModel::class,'policy_setting_id','id');
    }
    public function policy_name(){
        return $this->belongsTo(PolicySettingModel::class,'policy_setting_id','id')->select('id','name');
    }
}
