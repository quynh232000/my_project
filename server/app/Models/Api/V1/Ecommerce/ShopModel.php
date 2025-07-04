<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;
use Illuminate\Support\Carbon;

class ShopModel  extends ApiModel
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

            $query      = self::select('id', 'name', 'logo', 'bio', 'slug')
                        ->where('status', 'active');

            if ($params['shop_slug'] ?? false) {
                $result = $query->get()->map(function ($category) {
                            $category->haschild = $category->hasChild();
                            $category->allChildren;
                            return $category;
                        });
            }

            $query->withCount('product')->orderBy('product_count', 'desc')->limit($params['limit'] ?? 12);

            $result = $query->get();

            return $result;
        }
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
    public function products(){
        return ProductModel::where('shop_id', $this->id)->get();
    }
    public function product()
{
    return $this->hasMany(ProductModel::class);
}
    public function product_count()
    {
        return ProductModel::where('shop_id', $this->id)->count();
    }
    public function banks()
    {
        return UserBankModel::where('user_id', $this->user_id)->with('bank')->get();
    }
    // public function district()
    // {
    //     return $this->belongsTo(District::class);
    // }
    // public function ward()
    // {
    //     return Ward::where('code', $this->ward_code)->first();
    // }
    public function is_follow()
    {
        if (!auth('api')->check()) {
            return false;
        }
        return ShopFollowModel::where(['user_id' => auth('api')->id(), 'shop_id' => $this->id])->exists();
    }
    public function follow_count()
    {
        return ShopFollowModel::where('shop_id', $this->id)->count() ?? 0;
    }
    public function shop_dashboard()
    {
        $reviews_count      = ProductReviewModel::whereHas('product',function($query){
                                $query->where('shop_id', $this->id);
                            })->count()??0;
        $product_sold_count = OrderDetailModel::whereHas('order_shop',function($query){
                                $query->where('shop_id', $this->id);
                            })->sum('quantity')??0;
        return [
                    'product_count'         => $this->product_count(),
                    'follow_count'          => $this->follow_count(),
                    'voucher_count'         => $this->activeVouchers()->count(),
                    'reviews_count'         =>$reviews_count,
                    'product_sold_count'    => $product_sold_count,
                ];
    }
    public function vouchers()
    {
        return $this->hasMany(VoucherModel::class,'shop_id','id');
    }
    public function activeVouchers($limit=20)
    {
        return $this->vouchers()
            ->where('date_start', '<=', Carbon::now())
            ->where('date_end', '>=', Carbon::now())
            ->with('shop')
            ->limit($limit)
            ->get()->map(function ($item)  {
                $item->is_save = $item->is_save();
                return $item;
            });
    }

    public function getRepliesCountAttribute()
    {
        return $this->reply->count();
    }
    public function money(){
        return OrderShopModel::where('status','COMPLETED')->sum('total') ?? 0;
    }
    public function count(){
        $data['product']        = ProductModel::where('shop_id',$this->id)->count();
        $data['product_new']    = ProductModel::where(['shop_id'=>$this->id,'status'=>'PENDING'])->count();
        $data['product_active'] = ProductModel::where(['shop_id'=>$this->id,'status'=>'ACTIVE'])->count();
        $data['product_deny']   = ProductModel::where(['shop_id'=>$this->id,'status'=>'DENY'])->count();

        return $data;
    }
    public function livestream() {
        $live = LivestreamModel::where(['user_id'=>$this->user_id,'status'=>'live'])->first();

        return [
            'is_live' => $live ? true:false,
            'live'=>$live
        ];

    }
}
