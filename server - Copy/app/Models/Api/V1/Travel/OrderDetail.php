<?php

namespace App\Models\Api\V1\Travel;

use App\Models\ApiModel;

class OrderDetail extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.travel.' . self::getTable());
        parent::__construct();
    }
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'quantity_child',
        'quantity_baby',
        'additional_fee',
        'price',
        'price_child',
        'price_baby',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
