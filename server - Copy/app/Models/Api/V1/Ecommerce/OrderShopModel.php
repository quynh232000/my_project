<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Events\Api\V1\Ecommerce\OrderStatus;
use App\Http\Controllers\Api\V1\Ecommerce\OrderController;
use App\Models\ApiModel;

class OrderShopModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
     protected $guarded       = [];
    protected $order_states = array(
        'PENDING' => ['column' => 'payment_status', 'value' => 'PENDING',],
        'PAID' => ['column' => 'payment_status', 'value' => 'PAID',],
        'FAILED' => ['column' => 'payment_status', 'value' => 'FAILED',],
        'NEW' => ['column' => 'status', 'value' => 'NEW',],
        'PROCESSING' => ['column' => 'status', 'value' => 'PROCESSING',],
        'CONFIRMED' => ['column' => 'status', 'value' => 'CONFIRMED',],
        'ONDELIVERY' => ['column' => 'status', 'value' => 'ONDELIVERY',],
        'COMPLETED' => ['column' => 'status', 'value' => 'COMPLETED',],
        'CANCELLED' => ['column' => 'status', 'value' => 'CANCELLED',],
    );
    /*
    protected $order_status_updates = array(

        'NEW' => ['CANCELLED', 'PROCESSING',],
        'PROCESSING' => ['CANCELLED', 'CONFIRMED',],
        'CONFIRMED' => ['CANCELLED'],
    );
    */
    protected $order_status_updates = array(

        'PROCESSING' => 'NEW',
        'CONFIRMED' => 'PROCESSING',
        'CANCELLED' => ['NEW', 'PROCESSING',],
    );

    public function getOrderStatusUpdates()
    {
        return $this->order_status_updates;
    }

    public function updateOrderStatus($ids = [], $status = null)
    {
        $shop_order_builder = self::where('shop_id', auth('ecommerce')->user()->shop->id);


        if ($status) {
            if (in_array($status, array_keys($this->order_status_updates))) {
                $shop_order_builder = $status === "CANCELLED" ? $shop_order_builder->whereIn('status', $this->order_status_updates[$status]) : $shop_order_builder->where('status', $this->order_status_updates[$status]);
            } else {
                return (new OrderController())->errorResponse('Không thể cập nhật trạng thái đơn hàng', null, 404);
            }
        } else {
            /*** (FUTURE) update with no status at all */

            return (new OrderController())->errorResponse('Vui lòng nhập trạng thái đơn hàng muốn cập nhật.', null, 404);
        }

        /*** (OPTIONAL) update with ids */

        $list_orders = $ids ? $shop_order_builder->whereIn('id', $ids)->get() : $shop_order_builder->get();


        $update_list_orders = collect($list_orders)->map(function ($order) use ($status) {
            $order['status'] = $status;
            $order->addTracking('SHOP', $status);
            event(new OrderStatus($order->id, $order->status));
            $order->save();
            return $order;
        })->toArray();

        if (count($update_list_orders) > 0) {
            return (new OrderController())->successResponse('Thay đổi trạng thái đơn hàng thành công', $update_list_orders);
        } else {
            return (new OrderController())->errorResponse('Không có đơn hàng nào để cập nhật.', null, 404);
        }
    }

    protected $order_params = ["order_code", "user_id", "payment_method_id", "address_id", "total", "subtotal", "voucher_quin_id", "coin_transaction_id",];
    protected $order_detail_params = ["order_shop_id", "product_id", "quantity", "price",];
    public function shop()
    {
        return $this->belongsTo(ShopModel::class,'shop_id','id');
    }
    public function order()
    {
        return $this->belongsTo(OrderModel::class,'order_id','id');
    }
    public function order_details()
    {
        return $this->hasMany(OrderDetailModel::class,'order_shop_id','id');
    }
    public function voucher_shop()
    {
        return $this->belongsTo(VoucherModel::class, 'voucher_shop_id', 'id');
    }
    public function order_trackings()
    {
        return $this->hasMany(OrderTrackingModel::class,'order_shop_id','id');
    }
    public function getERNames()
    {
        return [
            'shop',
            'order.user',
            'order_details.product.category',
            'voucher_shop',
            'order.address.province',
            'order.address.district',
            'order.address.ward',
            'trackings'
        ];
    }
    public function getERData()
    {
        return $this->load($this->getERNames());
    }
    public function getFilters()
    {
        foreach (request()->all() as $column => $value) {

            if (in_array($column, ['limit', 'page', 'sort_by', 'sort_direction'])) {
                continue;
            }

            if (strtolower(trim($column)) == 'states' && $this->order_states[strtoupper(trim($value))]) {
                $state = $this->order_states[strtoupper(trim($value))];
                $this->filters = $this->addFilter($state['column'], $state['value'], );
            } else if (in_array($column, $this->order_params)) {

                $this->filters = $this->addFilter($column, $value, 'order');
            } else if (in_array($column, $this->order_detail_params)) {
                $this->filters = $this->addFilter($column, $value, 'orderDetails');
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
    function addTracking($from, $status)
    {
        OrderTrackingModel::create([
            'status' => $status,
            'from' => $from,
            'order_shop_id' => $this->id,
        ]);
    }
    public function trackings()
    {
        return $this->hasMany(OrderTrackingModel::class,'order_shop_id','id')->orderBy('created_at', 'desc');
    }
    public function commistion_fee()
    {
        $orderDetails = $this->order_details()->with('product.category')->get();
        return $orderDetails->sum(function ($orderDetail) {
            $commissionFee = $orderDetail->product->category->commission_fee ?? 0;
            return $orderDetail->quantity * ($orderDetail->price * ($commissionFee / 100));
        });
    }
    public function returnSoldProduct()
    {
        $orderDetails = $this->order_details;
        foreach ($orderDetails as $detail) {
            $detail->product->returnSold($detail->quantity);
        }

    }

}
