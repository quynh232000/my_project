<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class ProductLiveModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }
    public function cart_products()
    {
        return $this->hasMany(CartProductLiveModel::class, 'product_live_id', 'id');
    }
}
