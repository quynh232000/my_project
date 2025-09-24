<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\OrderShopModel;
use App\Models\Api\V1\Ecommerce\ProductModel;
use App\Models\Api\V1\Ecommerce\VoucherModel;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function dashboard(Request $request){
        try {
            $shop_id                     = auth('ecommerce')->user()->shop->id;
            $data['count']['voucher']    = VoucherModel::where('shop_id',$shop_id)->count();
            $data['count']['product_total']    = ProductModel::where('shop_id',$shop_id)->count();
            $data['count']['product_hidden']   = ProductModel::where('shop_id',$shop_id)->where('is_published',false)->count();
            $data['count']['product_sold']     = ProductModel::where('shop_id',$shop_id)->sum('sold');
            $data['count']['product_out']      = ProductModel::where('shop_id',$shop_id)
                                                ->whereRaw('stock - sold < ?', [10])->count();
            $data['count']['product_cancel']   = ProductModel::where('shop_id',$shop_id)->where('status','DENY')->sum('sold');
            $data['count']['order']            = OrderShopModel::where('shop_id',$shop_id)->count();
            $data['count']['order_new']        = OrderShopModel::where('shop_id',$shop_id)->where('status','NEW')->count();
            $data['count']['order_complete']   = OrderShopModel::where('shop_id',$shop_id)->where('status','COMPLETED')->count();
            $data['count']['order_processing'] = OrderShopModel::where('shop_id',$shop_id)->where('status','PROCESSING')->count();
            $data['count']['confirm']          = OrderShopModel::where('shop_id',$shop_id)->where('status','CONFIRMED')->count();
            $data['count']['ondelivery']       = OrderShopModel::where('shop_id',$shop_id)->where('status','ONDELIVERY')->count();
            $data['count']['order_cancel']     = OrderShopModel::where('shop_id',$shop_id)->where('status','CANCELLED')->count();
            $data['count']['order_revenue']    = OrderShopModel::where('shop_id',$shop_id)->where('status','COMPLETED')->sum('total');


            $data['product_list']     = ProductModel::where('shop_id',$shop_id)->with('category')
                                                        // ->whereRaw('stock - sold < ?', [1000])
                                                        ->orderBy('sold','desc')->limit(5)->get();

            $data['order_new_list']        = OrderShopModel::where('shop_id',$shop_id)
                                            ->where('status','NEW')->orderBy('created_at','desc')
                                            ->limit(10)->get();

            $data['order_month'] = OrderShopModel::where('shop_id', $shop_id)
                                    ->where('created_at', '>=', Carbon::now()->subMonths(12)) // Lấy dữ liệu trong 12 tháng gần nhất
                                    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                                    ->groupBy('month')
                                    ->orderBy('month', 'desc')
                                    ->get();

            return $this->successResponse('ok',$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
