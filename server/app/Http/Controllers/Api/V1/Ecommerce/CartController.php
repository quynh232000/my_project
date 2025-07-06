<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\AddressModel;
use App\Models\Api\V1\Ecommerce\CartModel;
use App\Models\Api\V1\Ecommerce\ProductModel;
use App\Models\Api\V1\Ecommerce\ShopModel;
use App\Services\GhnApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new CartModel();
        parent::__construct($request);
    }
    public function add_to_cart(Request $request)
    {
        try {
            $validate       = Validator::make($request->all(), [
                                'product_id'    => 'required',
                                'quantity'      => 'required|integer|min:1',
                            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin', $validate->errors());
            }
            $product        = ProductModel::find($request->product_id);
            if (!$product) {
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            if ($request->quantity < 1) {
                return $this->errorResponse('Số lượng sản phẩm phải lớn hơn 0');
            }
            if ($request->quantity > ($product->stock - $product->sold)) {
                return $this->errorResponse('Sản phẩm không đủ số lượng hết hàng');
            }
            $cart                   = CartModel::where(['user_id' => auth('ecommerce')->id(), 'product_id' => $request->product_id])->first();
            if ($cart) {
                $cart->quantity     += $request->quantity;
                $cart->is_checked   = $request->is_checked ?? $cart->is_checked;
                $cart->save();
            } else {
                $cart               = CartModel::create([
                                        'user_id'       => auth('ecommerce')->id(),
                                        'product_id'    => $request->product_id,
                                        'quantity'      => $request->quantity
                                    ]);
            }
            return $this->successResponse('Thêm sản phẩm vào giỏ hàng thành công!');
        } catch (Exception $e) {
            return $this->errorResponse('ĐÃ có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function asyn_cart(Request $request)
    {
        try {
            if (($request->products && is_array($request->products) && count($request->products))) {
                foreach ($request->products as $key => $product) {
                    $product_db     = ProductModel::find($product['product_id']);
                    if ($product_db && $product['quantity'] <= ($product_db->stock - $product_db->sold)) {
                        CartModel::updateOrCreate(
                            [
                                'user_id'       => auth('ecommerce')->id(),
                                'product_id'    => $product['product_id']
                            ],
                            [
                                'quantity'      => $product['quantity'],
                                'is_checked'    => $product['is_checked'] ?? true,
                            ]
                        );
                    }
                }
            }
            $cart                   = CartModel::where('user_id', auth('ecommerce')->id())->with('product.shop')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            return $this->successResponse('Đồng bộ giỏ hàng thành công!', $cart);
        } catch (Exception $e) {
            return $this->errorResponse('ĐÃ có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function update_cart(Request $request)
    {
        try {
            if ($request->type == 'clear') {
                CartModel::where(['user_id' => auth('ecommerce')->id()])->delete();
                return $this->successResponse('Xóa toàn bộ giỏ hàng thành công!');
            }
            $product = ProductModel::find($request->product_id);
            if (!$product) {
                return $this->errorResponse('Sản phẩm không tồn tại');
            }
            $cart = CartModel::where(['user_id' => auth('ecommerce')->id(), 'product_id' => $request->product_id])->first();
            if (!$cart) {
                return $this->errorResponse('Sản phẩm không tồn tại trong giỏ hàng');
            }
            switch ($request->type) {
                case 'minus':
                    if ($cart->quantity > 1) {
                        $cart->quantity -= 1;
                        $cart->save();
                        return $this->successResponse('Cập nhật giỏ hàng thành công!');
                    } else {
                        CartModel::where(['user_id' => auth('ecommerce')->id(), 'product_id' => $request->product_id])->delete();
                        return $this->successResponse('Xóa sản phẩm khỏi giỏ hàng thành công!');
                    }
                case 'plus':

                    if ($cart->quantity < ($product->stock - $product->sold)) {
                        $cart->quantity += 1;
                        $cart->save();
                        return $this->successResponse('Cập nhật giỏ hàng thành công!');
                    } else {
                        return $this->errorResponse('Sản phẩm đã hết hàng');
                    }
                case 'quantity':
                    if ($request->quantity >= 1 && $request->quantity <= ($product->stock - $product->sold)) {
                        $cart->quantity = $request->quantity;
                        $cart->save();
                        return $this->successResponse('Cập nhật giỏ hàng thành công!');
                    } else {
                        return $this->errorResponse('Số lượng sản phẩm phải lớn hơn 0 và nhỏ hơn tồn kho');
                    }
                case 'is_checked':
                    $cart->is_checked = !$cart->is_checked;
                    $cart->save();
                    return $this->successResponse('Cập nhật trạng thái sản phẩm thành công!');
                case 'delete':
                    $cart->delete();
                    return $this->successResponse('Xóa sản phẩm khỏi giỏ hàng thành công!');
                default:
                    return $this->errorResponse('Loại cập nhật không hợp lệ');
            }
        } catch (Exception $e) {
            return $this->errorResponse('ĐÃ có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function get_fee_ship()
    {
        try {
            $address    = AddressModel::where(['user_id' => auth('ecommerce')->id(), 'is_default' => true])->first();
            if (!$address) {
                return $this->errorResponse('Vui lòng cập nhật địa chỉ');
            }
            $cart       = CartModel::where(['user_id' => auth('ecommerce')->id(), 'is_checked' => true])->with('product.shipping', 'product.shop')->get();
            if ($cart->count() == 0) {
                return $this->errorResponse('Giỏ hàng rỗng');
            }
            $data       = [];
            foreach ($cart as $item) {
                $cv     = ($item->product->shipping->width + $item->product->shipping->length) * 2 * $item->product->shipping->height * $item->quantity;
                $weight = $item->product->shipping->weight * $item->quantity;
                if (!isset($data[$item->product->shop_id])) {
                    $data[$item->product->shop_id]['cv'] = 0;
                    $data[$item->product->shop_id]['weight'] = 0;
                    $data[$item->product->shop_id]['total'] = 0;
                }
                $data[$item->product->shop_id]['cv'] += $cv;
                $data[$item->product->shop_id]['weight'] += $weight;
                $data[$item->product->shop_id]['total'] += $item->product->price * $item->quantity;
            }
            // get shipping fee from GHN
            $data_response  = [];

            $GHNService     = new GhnApiService();
            foreach ($data as $shop_id => $item) {
                $shop       = ShopModel::find($shop_id);
                $x          = floor(sqrt($item['cv'] / 4));
                $weight     = $item['weight'];

                $params     = [
                                'service_id'        => 53320,
                                "from_district_id"  => $shop->district_id,
                                "to_district_id"    => $address->district_id,
                                "to_ward_code"      => "21012",
                                "height"            => $x,
                                "length"            => $x,
                                "width"             => $x,
                                "weight"            => $item['weight'],
                                'insurance_value'   => $item['total']
                            ];
                $response   = $GHNService->get_data('/v2/shipping-order/fee', $params);
                $info       = ['shop_id' => $shop->id];

                $info['params']             = $params;
                if ($response->successful()) {
                    $dataRes                = $response->json()['data'];
                    $info['shipping_info']  = $dataRes;
                } else {
                    $info['error']          = json_decode($response->body());
                }
                $data_response[]            = $info;
            }

            return $this->successResponse('success', $data_response);
        } catch (Exception $e) {
            return $this->errorResponse('ĐÃ có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
}
