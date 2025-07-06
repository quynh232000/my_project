<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class VoucherModel  extends ApiModel
{
    use SoftDeletes, HasFilters;
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $hiddens = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'status',
        'deleted_at',
        'shop_id'
    ];
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "list") {

            $vouchers      = self::where('status', 'active')
                            ->where('date_end', '>=', Carbon::now())
                            ->where('quantity', '>', 'used_quantity')
                            ->with('shop:id,name,logo');

            if (auth('ecommerce')->check() && !isset($params['shop_id']) && !isset($params['from'])) {
                $my_vouchers = UserVoucherModel::where('user_id', auth('ecommerce')->id())->pluck('voucher_id')->all();
                if (count($my_vouchers) > 0) {
                    $vouchers->whereNotIn('id', $my_vouchers);
                }
            }
            if ($params['shop_id'] ??false) {
                if (!ShopModel::where('id', $params['shop_id'])->exists()) {
                    return $this->errorResponse('Shop not found', null, 404);
                }
                $vouchers->where('shop_id', $params['shop_id'])->where('from', 'SHOP');
            }
            if (isset($params['from']) && strtoupper($params['from']) == 'ADMIN') {
                $vouchers->where('from', 'ADMIN');
            }
            if (isset($params['order_by']) && ($params['order_type'] == 'desc' || $params['order_type'] == 'asc')) {
                $vouchers = $vouchers->orderBy($params['order_by'], $params['order_type']);
            }
            // $vouchers = Voucher::query();
            $vouchers = $vouchers->paginate($params['limit'] ??20, ['*'], 'page', $params['page'] ??1);
            $vouchers->getCollection()->transform(function ($item) {
                $item->is_save = $item->is_save();
                return $item;
            });

            return $vouchers;
        }
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
        }
        if ($options['task'] == 'edit-item') {
        }
    }
     public function shop()
    {
        return $this->belongsTo(ShopModel::class);
    }
    // public function order_shop()
    // {
    //     return $this->has(OrderShop::class);
    // }
    public function is_save()
    {
        if (!auth('ecommerce')->check()) {
            return false;
        }
        return UserVoucherModel::where(['voucher_id' => $this->id, 'user_id' => auth('ecommerce')->id()])->exists();
    }
    public function getStatusAttribute(){
        $status = 'active';
        if($this->date_start <= now() && $this->date_end >= now()){
            $status = 'active';
        }else if($this->date_end < now()){
            $status = 'end';
        }
        return $status;
    }
}
