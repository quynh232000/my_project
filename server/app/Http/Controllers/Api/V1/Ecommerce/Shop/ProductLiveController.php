<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Events\Api\V1\Ecommerce\LiveChat;
use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\CartProductLiveModel;
use App\Models\Api\V1\Ecommerce\LivestreamModel;
use App\Models\Api\V1\Ecommerce\ProductLiveModel;
use Illuminate\Http\Request;
use Validator;

class ProductLiveController extends Controller
{
    public function addProduct(Request $request) {
        try {

            $validate = Validator::make($request->all(),[
                'product_id',
                'live_name',
                'price'
            ]);
            if($validate->fails()){
                return $this->errorResponse('Lỗi ',$validate->errors());
            }
            $live = LivestreamModel::where(['name' => $request->live_name,'user_id'=>auth('ecommerce')->id()])->first();

            if(!$live){
                return $this->errorResponse('Lỗi live k hợp lệ');
            }
            if($live->status != 'live'){
                return $this->errorResponse('Trạng thái phiên live không hợp lệ để thực hiện thao tác',$live);
            }
            $product_live = ProductLiveModel::where([
                'live_id'       => $live->id,
                'status'        => 'active'
            ])->first();
            if(!$product_live){
                $product_live = ProductLiveModel::create([
                    'live_id'       => $live->id,
                    'status'        => 'active',
                    'product_id'    => $request->product_id,
                    'price'         => $request->price
                ]);
            }else{
                if($product_live->product_id != $request->product_id){
                    $product_live->status = 'inactive';

                    $product_live->save();
                    $product_live       = ProductLiveModel::create([
                        'live_id'       => $live->id,
                        'status'        => 'active',
                        'product_id'    => $request->product_id,
                        'price'         => $request->price
                    ]);
                }else{
                    $product_live->price = $request->price;
                    $product_live->save();
                }
            }
            $product_live->product = $product_live->product;
            event(new LiveChat($live->id,null,null,null,[
                'product_live' => $product_live
            ]));
            return $this->successResponse('Tạo yêu cầu thành công!',$product_live);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function addCart(Request $request) {
        try {
            $validate = Validator::make($request->all(),[
                'live_id',
                'product_live_id',
                'quantity'
            ]);
            if($validate->fails()){
                return $this->errorResponse('Lỗi thông tin dữ liệu',$validate->errors());
            }

            $live = LivestreamModel::where(['id'=>$request->live_id,'status'=>'live'])->first();
            if(!$live){
                return $this->errorResponse('Phiên live không tìm thấy hoặc đã kết thúc');
            }
            $cart = CartProductLiveModel::updateOrCreate([
                'user_id'           => auth('ecommerce')->id(),
                'product_live_id'   => $request->product_live_id,
                'status' => 'new'
            ],[
                'user_id'           =>auth('ecommerce')->id(),
                'product_live_id'   => $request->product_live_id,
                'quantity'          => $request->quantity,
                'status'            => 'new'
            ]);

            return $this->successResponse('Đã đặt hàng thành công!',$cart);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
