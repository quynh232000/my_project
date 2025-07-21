<?php

namespace App\Models\Api\V1\Travel;

use App\Models\ApiModel;

class Order extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.travel.' . self::getTable());
        parent::__construct();
    }
    protected $fillable  = [
        'email',
        'full_name',
        'address',
        'note',
        'phone_number',
        'status',
        'payment_status',
        'subtotal',
        'total'
    ];

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
