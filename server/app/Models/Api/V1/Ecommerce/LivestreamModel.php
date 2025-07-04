<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class LivestreamModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "list") {

            $query      = self::select('id','key','name','view','title','thumbnail_url','user_id')
                    ->where('status','live')
                    ->with([
                        'user:id',
                        'user.shop:user_id,id,name,logo',
                    ])->limit($request->limit ??20)
                    ->orderBy('created_at','desc');

            if($params['limit'] ?? false){
                $query->limit($params['limit'] ?? 12);
            }
            $result = $query->get();

            return $result;
        }
    }
     public function user() {
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
    public function messages() {
        return $this->hasMany(LiveChatModel::class,'livestream_id','id');
    }
    public function addView() {
        $this->increment('view');
    }

    public function currentProduct() {
       return  ProductLiveModel::where([
            'live_id'   => $this->id,
            'status'    => 'active'
        ])->with('product')->first() ?? null;
    }
    public function products() {
        return $this->hasMany(ProductLiveModel::class,'live_id','id');
    }
    public function orders()  {

        return CartProductLiveModel::
        with('product_live.product','user')
        ->whereHas('product_live',function($q){
            $q->where('live_id',$this->id);
        })
        ->
        orderBy('created_at','desc')
        ->limit(20)->get();
    }
}
