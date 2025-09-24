<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class OrderDetailModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function orderShop()
    {
        return $this->belongsTo(OrderShopModel::class, 'order_shop_id');
    }
    protected $ERNames = [

        'order_shop',
        'product',
    ];
    protected $product_params = ["slug", "name", "image", "sku", "description", "video", "percent_sale", "origin", "category_id", "brand_id", "stock", "sold", "view_count", "priority"];

    protected $order_shop_params = ["order_id", "voucher_shop_id", "note", "total", "subtotal", "status", "payment_status", "shipping_fee"];

    public function order_shop()
    {
        return $this->belongsTo(OrderShopModel::class,'order_shop_id','id');
    }
    public function product()
    {
        return $this->belongsTo(ProductModel::class,'product_id','id');
    }
    public function getER()
    {
        return $this->with($this->ERNames)->get();
    }
    public function getERNames()
    {
        return $this->ERNames;
    }
    public function getERData()
    {
        return $this->load($this->ERNames);
    }

    public function getFilters()
    {
        foreach (request()->all() as $column => $value) {

            if (in_array($column, ['limit', 'page', 'sort_by', 'sort_direction'])) {
                continue;
            }

            if (in_array($column, $this->product_params)) {
                $this->filters = $this->addFilter($column, $value, 'product');
            } else if (in_array($column, $this->order_shop_params)) {
                $this->filters = $this->addFilter($column, $value, 'order_shop');
            } else {
                $this->filters = $this->addFilter($column, $value);
            }
        }
        return $this->filters;
    }
    protected function addFilter($column, $value, $relation = null)
    {
        $this->filters[] = compact(['column', 'value', 'relation']);
        return $this->filters;
    }

}
