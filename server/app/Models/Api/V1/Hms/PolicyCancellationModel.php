<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PolicyCancellationModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POLICY_CANCELLATION;
        parent::__construct();
    }
    protected $guarded      = [];
    protected $hidden       = ['created_at', 'created_by', 'updated_at'];
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;

            $results    = self::where('hotel_id',$hotel_id)
                       ->with(['cancel_rules','priceTypes'=> function($q) {
                            $q->select('id','name','policy_cancel_id')->whereNull('deleted_at');
                        }])
                        ->get()
                        ->groupBy('is_global')
                        ->mapWithKeys(function ($items, $key) {
                            if($key){
                               return ['global' =>
                                [
                                    ...$items[0]->toArray(),
                                    'price_types'   =>  $items[0]->priceTypeApplyGlobal()
                                ]
                                ];
                            }
                            return ['local' => $items];
                        });
        }
        if ($options['task'] == 'list_not_global') {
            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $results    = self::where(['hotel_id' => $hotel_id, 'is_global' => $params['type'] == 'not_global' ? 0 :1])
                        ->orderBy('created_at','desc')
                        ->get();
        }
        return $results;
    }
    public function saveItem($params = null, $options = null){
        $result         = null;

        if ($options['task'] == 'edit-item') {
            $hotel_id   = auth('hms')->user()->current_hotel_id;

            if($params['is_global']){
                // chinh sach chung
                if($params['status'] == 'active'){
                    // neu co thi tao hoac cap nhat; khong co thi xoa
                    $item = self::updateOrCreate([
                        'is_global'     => 1,
                        'hotel_id'      => $hotel_id
                    ],[
                        'is_global'     => 1,
                        'hotel_id'      => $hotel_id,
                        'status'        => "active",
                        'name'          => '',
                        'created_by'    => auth('hms')->id(),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);

                    $PolicyCancellRule = new PolicyCancelRuleModel();
                    $PolicyCancellRule->saveItem($params['policy_rules'],[...$options,'insert_id' => $item->id]);

                }else{
                    $item = self::where(['is_global' => 1,'hotel_id' => $hotel_id])->first();
                    if($item){
                        $item->delete();
                        $PolicyCancellRule = new PolicyCancelRuleModel();
                        $PolicyCancellRule->deleteItem($item->id,['task'=>'delete-all']);
                    }
                }
            }else{
                // chinh sach rieng
                $item = self::updateOrCreate([
                    'is_global'     => 0,
                    'hotel_id'      => $hotel_id,
                    'id'            => $params['id'] ?? null
                ],[
                    'is_global'     => 0,
                    'hotel_id'      => $hotel_id,
                    'status'        => $params['status'],
                    'name'          => $params['name'],
                    'code'          => $params['code'],
                    'created_by'    => auth('hms')->id(),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                
                $PolicyCancellRule = new PolicyCancelRuleModel();
                $PolicyCancellRule->saveItem($params['policy_rules'],[...$options,'insert_id' => $item->id]);

                // xóa chính sách được áp dụng bên loại giá
                if($params['status'] == 'inactive'){
                    PriceTypeModel::where(['hotel_id' => $hotel_id,'policy_cancel_id' => $params['id']])->update(['policy_cancel_id' => null]);
                }
            }

            $result = [
                'id' => $item->id
            ];

        }
        if($options['task'] == 'toggle-status'){
            
            $hotel_id       = auth('hms')->user()->current_hotel_id;

            $policy         = self::where(['hotel_id' => $hotel_id, 'id' => $params['id']])->first();
            if($policy->status == 'active'){
                // delete policy in price type
                PriceTypeModel::where(['hotel_id' => $hotel_id,'policy_cancel_id' => $params['id']])->update(['policy_cancel_id' => null]);
            }
            $policy->status = $policy->status == 'active' ? 'inactive' : 'active';
            
            $policy->save();
        }
        return $result;
    }
    public function getItem($params = null, $options = null){

        $result = null;
        if ($options['task'] == 'item-info') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $result     = self::with('cancel_rules')
                            ->where(['hotel_id' => $hotel_id, 'id' => (int)$params['id']])->first();
                    
        }
        
        return $result;
    }
    public function deleteItem($id, $options = null){
        if ($options['task'] == 'delete-item') {
            
            $hotel_id = auth('hms')->user()->current_hotel_id;
            self::where(['hotel_id' => $hotel_id,'id' => $id]) ->delete();

            // delete policy in price type
            PriceTypeModel::where(['hotel_id' => $hotel_id,'policy_cancel_id' => $id])->update(['policy_cancel_id' => null]);
        }
    }
    public function cancel_rules(){
        return $this->hasMany(PolicyCancelRuleModel::class,'policy_cancel_id','id');
    }
    public function priceTypes(){
        return $this->hasMany(PriceTypeModel::class,'policy_cancel_id','id');
    }
    public function priceTypeApplyGlobal(){
        return PriceTypeModel::select('id','name')
            ->where('hotel_id',auth('hms')->user()->current_hotel_id)
            ->whereNull('policy_cancel_id')
            ->whereNull('deleted_at')
            ->get();
    }
    public function policy_cancel_rules(){
        return $this->hasMany(PolicyCancelRuleModel::class,'policy_cancel_id','id');
    }
    public function price_types(){
        return $this->hasMany(PriceTypeModel::class,'policy_cancel_id','id');
    }
}
