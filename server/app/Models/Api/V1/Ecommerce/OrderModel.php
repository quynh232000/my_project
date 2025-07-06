<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class OrderModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
     protected $ERNames = [
        'order_shops',
        'user',
        'address',
        'payment_method',
        'voucher_quin',
        'coin_transaction'
    ];
    public function order_shops()
    {
        return $this->hasMany(OrderShopModel::class,'order_id','id');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
    public function address()
    {
        return $this->belongsTo(AddressModel::class,'address_id','id');
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethodModel::class,'payment_method_id','id');
    }
    public function voucher_quin()
    {
        return $this->belongsTo(VoucherModel::class, 'voucher_quin_id','id');
    }
    public function coin_transaction()
    {
        return $this->belongsTo(CoinTransactionModel::class, 'coin_transaction_id','id');
    }
    public function getERData()
    {
        return $this->load($this->ERNames);
    }
    public function order_details()
{
    return $this->hasManyThrough(
        OrderDetailModel::class, // Bảng cuối cùng
        OrderShopModel::class,   // Bảng trung gian
        'order_id',         // Khóa ngoại trong OrderShop trỏ đến Order (orders.id)
        'order_shop_id',    // Khóa ngoại trong OrderDetail trỏ đến OrderShop (order_shops.id)
        'id',               // Khóa chính của Order (orders.id)
        'id'                // Khóa chính của OrderShop (order_shops.id)
    );
}
}
