<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\OrderDetailModel;
use App\Models\Api\V1\Ecommerce\OrderShopModel;
use App\Models\AttributeName;
use App\Models\Brand;
use App\Models\Category;
// use App\Models\order;
use App\Models\orderAttribute;
use App\Models\OrderDetail;
use App\Models\OrderShop;
use App\Models\Shop;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Str;
use Validator;


class OrderController extends Controller
{


    public function order_index(Request $request)
    {
        try {
            $query = OrderShopModel::where('shop_id', auth('ecommerce')->user()->shop->id)->with(['order','order.user']);


            $limit = request('limit', 20);
            $page = request('page', 1);

            if(!empty($request->payment_status)){
                $query->where('payment_status',$request->payment_status);
            }
            if(!empty($request->payment_method_id)){
                $query->whereHas('order',function($query) use($request){
                    $query->where('payment_method_id',$request->payment_method_id);
                });
            }
            if($request->states){
                $query->where('status', $request->states);
            }


            if($request->sort){
                $sort = explode('.', $request->sort);
                $query->orderBy($sort[0], $sort[1]);
            }else{
                $query->orderBy('created_at', 'desc');
            }

            $orders = $query->paginate($limit, ['*'], 'page', $page);


            return $this->successResponsePagination('Lấy danh sách orders thành công', $orders->items(), $orders);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function order_get($id)
    {
        try {
            $order_shop = OrderShopModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$order_shop) {
                return $this->errorResponse('Đơn hàng này không tồn tại!', null, 404);
            }

            return $this->successResponse('Lấy chi tiết đơn hàng thành công', $order_shop->getERData());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function order_detail_index($id)
    {
        try {
            $order_shop = OrderShopModel::where('shop_id', auth('ecommerce')->user()->shop->id)->findOrFail($id);

            $limit = request('limit', 20);
            $page = request('page', 1);
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');

            $orders = OrderDetailModel::where('order_shop_id', $id)
                ->filterAndSort($order_shop->order_details[0]->getFilters(), $sort_by, $sort_direction)
                ->with($order_shop->order_details[0]->getERNames())
                ->paginate($limit, ['*'], 'page', $page);

            return $this->successResponsePagination('Lấy danh sách chi tiết đơn hàng thành công', $orders->items(), $orders);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function order_detail_get($id, $id_detail)
    {
        try {
            $shop_orders = OrderShopModel::where('shop_id', auth('ecommerce')->user()->shop->id)->findOrFail($id);

            $order_detail = $shop_orders->getERData()->order_details->find($id_detail);

            if (!$order_detail) {
                return $this->errorResponse('Đơn hàng chi tiết này không tồn tại!', null, 404);
            }

            return $this->successResponse('Lấy chi tiết đơn hàng thành công', $order_detail->getERData());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function order_update_status()
    {
        try {
            [$ids, $status] = array_values(request()->only("ids", "status"));

            return (new OrderShopModel())->updateOrderStatus($ids, $status);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
