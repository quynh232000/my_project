<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Events\Api\V1\Ecommerce\Notify;
use App\Http\Controllers\ApiController;
use App\Jobs\Api\V1\Ecommerce\SendOrderEmail;
use App\Models\Api\V1\Ecommerce\AddressModel;
use App\Models\Api\V1\Ecommerce\CartModel;
use App\Models\Api\V1\Ecommerce\CoinTransactionModel;
use App\Models\Api\V1\Ecommerce\NotificationHistoryModel;
use App\Models\Api\V1\Ecommerce\NotificationModel;
use App\Models\Api\V1\Ecommerce\OrderDetailModel;
use App\Models\Api\V1\Ecommerce\OrderModel;
use App\Models\Api\V1\Ecommerce\OrderShopModel;
use App\Models\Api\V1\Ecommerce\PaymentMethodModel;
use App\Models\Api\V1\Ecommerce\SettingModel;
use App\Models\Api\V1\Ecommerce\ShopModel;
use App\Models\Api\V1\Ecommerce\TransactionModel;
use App\Models\Api\V1\Ecommerce\UserVoucherModel;
use App\Models\Api\V1\Ecommerce\VoucherModel;
use App\Services\SePayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Str;

class OrderController extends ApiController
{
    public function __construct(Request $request)
    {;
        parent::__construct($request);
    }
    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $user           = auth('ecommerce')->user();
            $cart           = CartModel::where(['user_id' => auth('ecommerce')->id(), 'is_checked' => true])
                                ->with('product')->get();

            if ($cart->count() == 0) {
                DB::rollBack();
                return $this->errorResponse('Bạn chưa chọn sản phẩm nào!', 400);
            }
            $validate       = Validator::make($request->all(), [
                                    'payment_method_id'     => 'required',
                                    'address_id'            => 'required',
                                ]);
            if ($validate->fails()) {
                DB::rollBack();
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin', $validate->errors());
            }
            $payment_method = PaymentMethodModel::find($request->payment_method_id);
            if (!$payment_method) {
                DB::rollBack();
                return $this->errorResponse('Phương thức thanh toán không tồn tại!', 400);
            }
            if (!AddressModel::where(['user_id' => auth('ecommerce')->id(), 'id' => $request->address_id])->first()) {
                DB::rollBack();
                return $this->errorResponse('Địa chỉ không tồn tại!', 400);
            }
            //
            if (!$request->shops || !is_array($request->shops) || count($request->shops) == 0) {
                DB::rollBack();
                return $this->errorResponse('Dữ liệu không hợp lệ!', $request->all());
            }

            $subtotal           = 0;
            $shop_products      = [];
            $shop_ids           = [];
            $cart->map(function ($item) use (&$subtotal, &$shop_products, &$shop_ids) {
                $total          = $item->quantity * $item->product->price;
                $subtotal       += $total;
                // tách sp theo từng shop
                $shop_id        = $item->product->shop_id;
                // $item->quantity_buy = $item->quantity;
                $shop_products[$shop_id]['products'][] = $item;
                if (!isset($shop_products[$shop_id]['total'])) {
                    $shop_products[$shop_id]['total'] = $total;
                } else {
                    $shop_products[$shop_id]['total'] += $total;
                }
                if (!isset($shop_products[$shop_id]['subtotal'])) {
                    $shop_products[$shop_id]['subtotal'] = $total;
                } else {
                    $shop_products[$shop_id]['subtotal'] += $total;
                }
                if (!in_array($shop_id, $shop_ids)) {
                    $shop_ids[] = $shop_id;
                }
                $item->product->sold += $item->quantity;
                $item->product->save();
                return $item;
            });
            // check data input
            $check_req_shop_ids     = [];
            $voucher_amount         = 0;
            $shipping_fee_amount    = 0;
            foreach ($request->shops as $shop) {
                if (!in_array($shop['shop_id'], $shop_ids)) {
                    DB::rollBack();
                    return $this->errorResponse('Dữ liệu không hợp lệ: shop_id: ' . $shop['shop_id'] . ' không tồn tại sản phẩm nào trong giỏ hàng!', $shop['shop_id']);
                }
                if (in_array($shop['shop_id'], $check_req_shop_ids)) {
                    DB::rollBack();
                    return $this->errorResponse('Dữ liệu không hợp lệ: shop_id: ' . $shop['shop_id'] . ' không thể xuất hiện nhiều lần!', $shop['shop_id']);
                }
                // check shipping fee
                if (!isset($shop['shipping_fee'])) {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng nhập phí vận chuyển (shipping_fee) cho shop ' . $shop['shop_id']);
                }
                $shipping_fee_amount += $shop['shipping_fee'];
                $shop_products[$shop['shop_id']]['shipping_fee'] = $shop['shipping_fee'] ?? 0;

                if (!isset($shop_products[$shop['shop_id']]['voucher_discount'])) {
                    $shop_products[$shop['shop_id']]['voucher_discount'] = 0;
                }
                if (isset($shop['voucher_shop_id'])) {
                    $voucher            = VoucherModel::where(['shop_id' => $shop['shop_id'], 'id' => $shop['voucher_shop_id']])->first();
                    if (!$voucher) {
                        DB::rollBack();
                        return $this->errorResponse('Voucher không hợp lệ', $shop['voucher_shop_id']);
                    }
                    if ($shop_products[$shop['shop_id']]['total'] < $voucher->minimum_price) {
                        DB::rollBack();
                        return $this->errorResponse('Voucher không thể áp dụng đơn hàng này số tiền không đủ!', $shop['voucher_shop_id']);
                    }
                    UserVoucherModel::create([
                                            'user_id'       => $user->id,
                                            'voucher_id'    => $voucher->id,
                                            'is_used'       => true
                                        ]);
                    $voucher->used_quantity++;
                    $voucher->save();
                    $shop_products[$shop['shop_id']]['voucher_discount']    += $voucher->discount_amount;
                    $shop_products[$shop['shop_id']]['voucher_shop_id']     = $voucher->id;
                    $voucher_amount                                         += $voucher->discount_amount;
                }
                $check_req_shop_ids[]                                       = $shop['shop_id'];
                $shop_products[$shop['shop_id']]['note'] = $shop['note'] ?? '';
            }
            // check voucher quin
            // return 123;
            if ($request->voucher_quin_id) {
                $voucher_quin                                               = VoucherModel::where(['id' => $request->voucher_quin_id, 'from' => 'ADMIN'])->first();
                if (!$voucher_quin) {
                    DB::rollBack();
                    return $this->errorResponse('Voucher Quin không tồn tại!', $request->voucher_quin_id);
                }
                if ($subtotal < $voucher_quin->minimum_price) {
                    DB::rollBack();
                    return $this->errorResponse('Voucher không thể áp dụng đơn hàng này số tiền không đủ!', $request->voucher_quin_id);
                }
                UserVoucherModel::create([
                                            'user_id'       => $user->id,
                                            'voucher_id'    => $voucher_quin->id,
                                            'is_used'       => true
                                        ]);
                $voucher_quin->used_quantity++;
                $voucher_quin->save();
                $voucher_amount         += $voucher_quin->discount_amount;
            }
            // create order

            $total                      = $subtotal - $voucher_amount + $shipping_fee_amount;
            // check xu to use
            if ($request->coin_to_use) {
                $get_coin_setting       = SettingModel::find(4)->value ?? 0;
                $user_coin              = $user->total_coin();
                $max_coin_use           = $total * ($get_coin_setting / 100);
                if ($request->coin_to_use > $user_coin) {
                    DB::rollBack();
                    return $this->errorResponse('Số coin trong ví của bạn không đủ để áp dụng');
                }
                if ($request->coin_to_use > $max_coin_use) {
                    DB::rollBack();
                    return $this->errorResponse('Bạn chỉ có thể áp dụng tối đa: ' . $max_coin_use . ' XU cho đơn hàng này');
                }
                $coin_transaction = CoinTransactionModel::create([
                                                                    'user_id'       => $user->id,
                                                                    'name'          => 'Áp dụng ' . $request->coin_to_use . ' XU thanh toán đơn hàng',
                                                                    'amount'        => -$request->coin_to_use,
                                                                    'balance_before' => $user_coin,
                                                                    'balance_after' => $user_coin - $request->coin_to_use,
                                                                    'reference_id'  => null,
                                                                    'description'   => 'Áp dụng cho đơn hàng của bạn',
                                                                ]);
                $total                          -= $request->coin_to_use;
            }

            // validate complete=================================================================================
            $payment_status         = 'PENDING';
            if ($payment_method->code == 'banking') {
                if (!$request->order_code) {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng nhập mã đơn hàng!');
                }
                $check_transaction  = TransactionModel::where(['order_code' => $request->order_code, 'amount_in' => $total])->first();
                if (!$check_transaction) {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng quét mã thanh toán cho đơn hàng này: ' . $request->order_code);
                }
                $payment_method = true;
                $orderCode = $request->order_code;
                $payment_status = 'PAID';
            } else {
                do {
                    $orderCode = 'ORD' . strtoupper(Str::random(6));
                } while (OrderModel::where('order_code', $orderCode)->exists());
            }

            $order = OrderModel::create([
                                // 'order_code' => strtoupper(uniqid('ORD')),
                                'order_code'        => $orderCode,
                                'user_id'           => $user->id,
                                'payment_method_id' => $request->payment_method_id,
                                'address_id'        => $request->address_id,
                                'total'             => $total,
                                'subtotal'          => $subtotal,
                                'voucher_quin_id'   => $request->voucher_quin_id ?? null,
                                'coin_transaction_id' => isset($coin_transaction) ? $coin_transaction->id : null,
                            ]);
            // $order->order_code = 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            $order->save();
            if (isset($coin_transaction)) {
                $coin_transaction->reference_id = $order->id;
                $coin_transaction->save();
            }

            // creat order shop and order detail
            foreach ($shop_products as $key => $value) {
                $order_shop     = OrderShopModel::create([
                                    'order_id'      => $order->id,
                                    'shop_id'       => $key,
                                    'total'         => $value['subtotal'] + $value['shipping_fee'] - $value['voucher_discount'],
                                    'subtotal'      => $value['subtotal'],
                                    'voucher_discount'  => $value['voucher_discount'],
                                    'voucher_shop_id'   => isset($value['voucher_shop_id']) ? $value['voucher_shop_id'] : null,
                                    'note'              => $value['note'],
                                    'payment_status'    => $payment_status,
                                    'shipping_fee'      => $value['shipping_fee'],
                                ]);
                foreach ($value['products'] as $product_item) {
                    OrderDetailModel::create([
                                                'order_shop_id' => $order_shop->id,
                                                'product_id'    => $product_item['product_id'],
                                                'quantity'      => $product_item['quantity'],
                                                'price'         => $product_item['product']['price'],
                                            ]);
                }
                // add tracking information
                $order_shop->addTracking('USER', 'NEW');
                // gửi thông báo đến shop
                $this->sendNotification($order_shop, $key, 'shop');
            }
            // delete cart
            CartModel::where(['user_id' => auth('ecommerce')->id(), 'is_checked' => true])->delete();


            // gửi thông báo đến user
            $this->sendNotification($order, auth('ecommerce')->id(), 'web');

            // $orderData = Order::find($order->id)->with('order_shops.order_details.product','address','payment_method','voucher_quin','coin_transaction','order_shops.voucher','order_shops.shop');

            DB::commit();
            return $this->successResponse('Đặt hàng thành công!', $order);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Đã có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function sendNotification($order, $id, $type)
    {
        if ($type == 'shop') {
            $shop       = ShopModel::find($id);
            $id         = $shop->user_id;
        }
        $notify         = NotificationModel::create(attributes: [
                            'title'         => $type == 'web' ? 'Đặt hàng thành công! #' . $order->order_code : 'Đơn hàng mới | ' . $order->id,
                            'message'       => 'Bạn có đơn hàng mới trị giá: ' . number_format($order->total, 0, ',', '.') . 'vnd',
                            'from'          => 'ORDER',
                            'to'            => strtoupper($type),
                            'sent_type'     => 'IMMEDIATE',
                            'status'        => 'SENT',
                            'type_target'   => 'USER',
                            'data_id'       => $type == 'web' ? $order->order_code : $order->id,
                            'target_ids'    => json_encode($id),
                        ]);
        $notify         = NotificationHistoryModel::create([
                            'notification_id' => $notify->id,
                            'user_id' => $id,
                        ]);
        $notify->load(['user', 'notification']);

        event(new Notify($notify));
        // send mail
        $email              = auth('ecommerce')->user()->email;
        $title              = '[Quin Ecommerce] - Đặt hàng thành công';
        $view               = 'email_order_user';
        $data['order']      = $order;
        if ($type == 'shop') {

            $email          = $shop->email;
            $title          = '[Quin Ecommerce] - Đơn hàng mới tại Quin Ecommerce';
            $view           = 'email_order_shop';
        }
        $data['email']      = $email;
        $data['title']      = $title;
        // Mail::send('email.'.$view, ['data' => $data], function ($message) use ($data) {
        //     $message->to($data['email'])->subject($data['title']);
        // });
        SendOrderEmail::dispatch('email.' . $view, $data);
    }
    public function order_payment_information(Request $request)
    {
        DB::beginTransaction();
        try {
            $user       = auth('ecommerce')->user();
            $cart       = CartModel::where(['user_id' => auth('ecommerce')->id(), 'is_checked' => true])->get();

            if ($cart->count() == 0) {
                DB::rollBack();
                return $this->errorResponse('Bạn chưa chọn sản phẩm nào!', 400);
            }
            $validate   = Validator::make($request->all(), [
                            'payment_method_id' => 'required',
                            'address_id'        => 'required',
                        ]);
            if ($validate->fails()) {
                DB::rollBack();
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin', $validate->errors());
            }
            if (!PaymentMethodModel::find($request->payment_method_id)) {
                DB::rollBack();
                return $this->errorResponse('Phương thức thanh toán không tồn tại!', 400);
            }
            if (!AddressModel::where(['user_id' => auth('ecommerce')->id(), 'id' => $request->address_id])->first()) {
                DB::rollBack();
                return $this->errorResponse('Địa chỉ không tồn tại!', 400);
            }
            //
            if (!$request->shops || !is_array($request->shops) || count($request->shops) == 0) {
                DB::rollBack();
                return $this->errorResponse('Dữ liệu không hợp lệ!', $request->all());
            }

            $subtotal           = 0;
            $shop_products      = [];
            $shop_ids           = [];
            $cart->map(function ($item) use (&$subtotal, &$shop_products, &$shop_ids) {
                $total      = $item->quantity * $item->product->price;
                $subtotal   += $total;
                // tách sp theo từng shop
                $shop_id    = $item->product->shop_id;
                // $item->quantity_buy = $item->quantity;
                $shop_products[$shop_id]['products'][] = $item;
                if (!isset($shop_products[$shop_id]['total'])) {
                    $shop_products[$shop_id]['total'] = $total;
                } else {
                    $shop_products[$shop_id]['total'] += $total;
                }
                if (!isset($shop_products[$shop_id]['subtotal'])) {
                    $shop_products[$shop_id]['subtotal'] = $total;
                } else {
                    $shop_products[$shop_id]['subtotal'] += $total;
                }
                if (!in_array($shop_id, $shop_ids)) {
                    $shop_ids[] = $shop_id;
                }
                return $item;
            });
            // check data input
            $check_req_shop_ids     = [];
            $voucher_amount         = 0;
            $shipping_fee_amount    = 0;
            foreach ($request->shops as $shop) {
                if (!in_array($shop['shop_id'], $shop_ids)) {
                    DB::rollBack();
                    return $this->errorResponse('Dữ liệu không hợp lệ: shop_id: ' . $shop['shop_id'] . ' không tồn tại sản phẩm nào trong giỏ hàng!', $shop['shop_id']);
                }
                if (in_array($shop['shop_id'], $check_req_shop_ids)) {
                    DB::rollBack();
                    return $this->errorResponse('Dữ liệu không hợp lệ: shop_id: ' . $shop['shop_id'] . ' không thể xuất hiện nhiều lần!', $shop['shop_id']);
                }
                // check shipping fee
                if (!isset($shop['shipping_fee'])) {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng nhập phí vận chuyển (shipping_fee) cho shop ' . $shop['shop_id']);
                }
                $shipping_fee_amount += $shop['shipping_fee'];
                $shop_products[$shop['shop_id']]['shipping_fee'] = $shop['shipping_fee'] ?? 0;

                if (!isset($shop_products[$shop['shop_id']]['voucher_discount'])) {
                    $shop_products[$shop['shop_id']]['voucher_discount'] = 0;
                }
                if (isset($shop['voucher_shop_id'])) {
                    $voucher        = VoucherModel::where(['shop_id' => $shop['shop_id'], 'id' => $shop['voucher_shop_id']])->first();
                    if (!$voucher) {
                        DB::rollBack();
                        return $this->errorResponse('Voucher không hợp lệ', $shop['voucher_shop_id']);
                    }
                    if ($shop_products[$shop['shop_id']]['total'] < $voucher->minimum_price) {
                        DB::rollBack();
                        return $this->errorResponse('Voucher không thể áp dụng đơn hàng này số tiền không đủ!', $shop['voucher_shop_id']);
                    }
                    UserVoucherModel::create([
                                        'user_id'       => $user->id,
                                        'voucher_id'    => $voucher->id,
                                        'is_used'       => true
                                    ]);
                    $voucher->used_quantity++;
                    $voucher->save();
                    $shop_products[$shop['shop_id']]['voucher_discount']    += $voucher->discount_amount;
                    $shop_products[$shop['shop_id']]['voucher_shop_id']     = $voucher->id;
                    $voucher_amount += $voucher->discount_amount;
                }
                $check_req_shop_ids[]                       = $shop['shop_id'];
                $shop_products[$shop['shop_id']]['note']    = $shop['note'] ?? '';
            }
            // check voucher quin
            if ($request->voucher_quin_id) {
                $voucher_quin                               = VoucherModel::where(['id' => $request->voucher_quin_id, 'from' => 'ADMIN'])->first();
                if (!$voucher_quin) {
                    DB::rollBack();
                    return $this->errorResponse('Voucher Quin không tồn tại!', $request->voucher_quin_id);
                }
                if ($subtotal < $voucher_quin->minimum_price) {
                    DB::rollBack();
                    return $this->errorResponse('Voucher không thể áp dụng đơn hàng này số tiền không đủ!', $request->voucher_quin_id);
                }
                $voucher_quin->used_quantity++;
                $voucher_quin->save();
                $voucher_amount += $voucher_quin->discount_amount;
            }
            // create order

            $total = $subtotal - $voucher_amount + $shipping_fee_amount;
            // check xu to use
            if ($request->coin_to_use) {
                $get_coin_setting   = SettingModel::find(4)->value ?? 0;
                $user_coin          = $user->total_coin();
                $max_coin_use       = $total * ($get_coin_setting / 100);
                if ($request->coin_to_use > $user_coin) {
                    DB::rollBack();
                    return $this->errorResponse('Số coin trong ví của bạn không đủ để áp dụng');
                }
                if ($request->coin_to_use > $max_coin_use) {
                    DB::rollBack();
                    return $this->errorResponse('Bạn chỉ có thể áp dụng tối đa: ' . $max_coin_use . ' XU cho đơn hàng này');
                }
                $total -= $request->coin_to_use;
            }
            // $order_code = strtoupper(uniqid('ORD'));
            do {
                $order_code = 'ORD' . strtoupper(Str::random(6));
            } while (OrderModel::where('order_code', $order_code)->exists());
            $bank_name          = SettingModel::where(['type' => 'BANK', 'key' => 'BANK_NAME'])->pluck('value')->first();
            $bank_number        = SettingModel::where(['type' => 'BANK', 'key' => 'BANK_NUMBER'])->pluck('value')->first();
            $bank_code          = SettingModel::where(['type' => 'BANK', 'key' => 'BANK_CODE'])->pluck('value')->first();
            $url                = "https://qr.sepay.vn/img?acc=$bank_number&bank=MB&amount=$total&des=$order_code";
            DB::commit();
            return $this->successResponse('Đặt hàng thành công!', [
                                            'order_code'    => $order_code,
                                            'total'         => $total,
                                            'bank_name'     => $bank_name,
                                            'bank_number'   => $bank_number,
                                            'bank_code'     => $bank_code,
                                            'url_qr_code'   => $url,
                                        ]);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Đã có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function check_status_payment(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate       = Validator::make($request->all(), [
                                'order_code'    => 'required',
                                'total'         => 'required|numeric',
                            ]);
            if ($validate->fails()) {
                DB::rollBack();
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validate->errors(), 400);
            }

            $check_order_payment    = TransactionModel::where(['order_code' => $request->order_code, 'amount_in' => $request->total])->first();
            if ($check_order_payment) {
                DB::commit();
                return $this->successResponse('Đơn hàng đã được thanh toán!', [
                                'check_amount'  => false,
                                'is_payment'    => true,
                                'order_code'    => $request->order_code,
                                'total'         => $request->total,
                            ]);
            }
            // check in transaction history in SePay
            $sePayService   = new SePayService();
            $res            = $sePayService->fetch_transactions();
            if (!$res['status']) {
                DB::rollBack();
                return $this->errorResponse('Không thể kết nối với SePay, vui lòng thử lại sau: ' . $res['message'], [
                    'check_amount'  => false,
                    'is_payment'    => false,
                    'order_code'    => $request->order_code,
                    'total'         => $request->total,
                ], 500);
            }
            // check is exist in transaction history
            foreach ($res['data'] as $key => $value) {
                if ($value['amount_in'] == $request->total && str_contains(strtoupper($value['transaction_content']), strtoupper($request->order_code))) {
                    TransactionModel::create([
                        'bank_id'               => $value['id'],
                        'bank_brand_name'       => $value['bank_brand_name'],
                        'order_code'            => $request->order_code,
                        'account_number'        => $value['account_number'],
                        'transaction_date'      => $value['transaction_date'],
                        'amount_out'            => $value['amount_out'],
                        'amount_in'             => $value['amount_in'],
                        'accumulated'           => $value['accumulated'],
                        'transaction_content'   => $value['transaction_content'],
                        'reference_number'      => $value['reference_number'],
                        'type'                  => 'ORDER',
                    ]);
                    DB::commit();
                    return $this->successResponse('Đơn hàng đã được thanh toán!', [
                        'check_amount'  => true,
                        'is_payment'    => true,
                        'order_code'    => $request->order_code,
                        'total'         => $request->total
                    ]);
                }
            }
            DB::commit();
            return $this->successResponse('Đơn hàng đang đợi thanh toán', [
                'check_amount'  => false,
                'is_payment'    => false,
                'order_code'    => $request->order_code,
                'total'         => $request->total,
                'res'           => $res
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Đã có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function checkoutVnpay(Request $request)
    {
        $VNP_TMN_CODE       = config('services.vnpay.vnp_tmn_code');
        $VNP_HASH_SECRET    = config('services.vnpay.vnp_hash_secret');
        $VNP_URL            = config('services.vnpay.vnp_url');
        $VNP_RETURN_URL     = config('services.vnpay.vnp_return_url');

        try {
            $startTime      = date("YmdHis");
            $expire         = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
            $vnp_TmnCode    = $VNP_TMN_CODE;
            $vnp_HashSecret = $VNP_HASH_SECRET;
            $vnp_Url        = $VNP_URL;
            $vnp_Returnurl  = $VNP_RETURN_URL . $request->return_url;

            $vnp_TxnRef     = rand(1, 10000);
            $vnp_OrderInfo  = "Payment for order #" . $vnp_TxnRef;
            $vnp_Amount     = $request->total * 100;
            $vnp_Locale     = 'vn';
            $vnp_BankCode   = $request->bank_name ?? '';
            $vnp_IpAddr     = $_SERVER['REMOTE_ADDR'];

            $inputData      = [
                                "vnp_Version"   => "2.1.0",
                                "vnp_TmnCode"   => $vnp_TmnCode,
                                "vnp_Amount"    => $vnp_Amount,
                                "vnp_Command"   => "pay",
                                "vnp_CreateDate" => $startTime,
                                "vnp_CurrCode"  => "VND",
                                "vnp_IpAddr"    => $vnp_IpAddr,
                                "vnp_Locale"    => $vnp_Locale,
                                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef . '-' . $vnp_OrderInfo,
                                "vnp_OrderType" => "other",
                                "vnp_ReturnUrl" => $vnp_Returnurl,
                                "vnp_TxnRef"    => $vnp_TxnRef,
                                "vnp_ExpireDate" => $expire
                            ];

            if (!empty($vnp_BankCode)) {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            // Sắp xếp và tạo chuỗi hash + query
            ksort($inputData);

            $query          = '';
            $hashdata       = '';
            $i              = 0;
            foreach ($inputData as $key => $value) {
                $value      = urlencode($value);
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . '=' . $value;
                } else {
                    $hashdata .= urlencode($key) . '=' . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . '=' . $value . '&';
            }

            // Tạo chữ ký bảo mật
            $vnpSecureHash  = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $paymentUrl     = $vnp_Url . '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

            return $this->successResponse('success', $paymentUrl);
        } catch (Exception $e) {
            return $this->errorResponse('Đã có lỗi xảy ra: ' . $e->getMessage(), 500);
        }


    }
    public function momo_info_payment(Request $request)
    {
        $ENDPOINT       = config('services.momo.ENDPOINT');
        $PARTNER_CODE   = config('services.momo.PARTNER_CODE');
        $ACCESS_KEY     = config('services.momo.ACCESS_KEY');
        $SECRET_KEY     = config('services.momo.SECRET_KEY');
        $FRONTEND_URL   = config('app.common.FRONTEND_URL');

        try {
            $orderInfo  = "Thanh toán đơn hàng Quin";
            $amount     = $request->total;
            $orderId    = random_int(00, 99999);
            $extraData  = "";

            $return_url = $FRONTEND_URL . $request->return_url;
            $requestId  = time() . "";
            $requestType = "payWithATM";
            // $requestType = "captureWallet";
            //before sign HMAC SHA256 signature
            $rawHash    = "accessKey=" . $ACCESS_KEY .
                            "&amount=" . $amount .
                            "&extraData=" . $extraData .
                            "&ipnUrl=" . $return_url .
                            "&orderId=" . $orderId .
                            "&orderInfo=" . $orderInfo .
                            "&partnerCode=" . $PARTNER_CODE .
                            "&redirectUrl=" . $return_url .
                            "&requestId=" . $requestId .
                            "&requestType=" . $requestType;

            $signature  = hash_hmac("sha256", $rawHash, $SECRET_KEY);
            $data       = array(
                            'partnerCode'   => $PARTNER_CODE,
                            'partnerName'   => "Test",
                            "storeId"       => "MomoTestStore",
                            'requestId'     => $requestId,
                            'amount'        => $amount,
                            'orderId'       => $orderId,
                            'orderInfo'     => $orderInfo,
                            'redirectUrl'   => $return_url,
                            'ipnUrl'        => $return_url,
                            'lang'          => 'vi',
                            'extraData'     => $extraData,
                            'requestType'   => $requestType,
                            'signature'     => $signature
                        );

            // check url
            $response       = Http::withHeaders([
                                'Content-Type' => 'application/json'
                            ])->post($ENDPOINT, $data);

            if ($response->successful()) {
                $resData        = $response->json();
                if ($resData['resultCode'] == 0) {
                    return $this->successResponse('success', $resData);
                } else {
                    return $this->errorResponse('Lỗi từ momo: ' . $resData['message'], $resData);
                }
            } else {
                return $this->errorResponse('Lỗi call momo endpoint: ' . $response->json());
            }
        } catch (Exception $e) {
            return $this->errorResponse('Đã có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function my_order_history(Request $request)
    {
        try {
            $page       = $request->page ?? 1;
            $limit      = $request->limit ?? 10;

            $query = OrderModel::select('ecommerce_orders.*')
                    ->where('user_id', auth('ecommerce')->id())
                    ->with([
                        'payment_method',
                        'voucher_quin',
                        'coin_transaction',
                        'address',
                        'order_shops.shop',
                        'order_shops.voucher_shop',
                        'order_shops.order_details.product',
                    ]);
            if (!empty($request->search)) {
                $query->where('order_code', 'LIKE', '%' . $request->search . '%');
            }
            if (!empty($request->status)) {
                $query->whereHas('order_shops',function($q)use($request){
                    $q->where('status',strtoupper($request->status));
                });
                // $query->leftJoin('order_shops as o1', 'o1.id', '=', 'orders.id')
                //     ->where('o1.status', '=', strtoupper($request->status));
            }
            if (!empty($request->sort)) {
                switch ($request->sort) {
                    case 'latest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'price_asc':
                        $query->orderBy('total', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('total', 'desc');
                        break;

                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $data   = $query->paginate($limit, ['*'], 'page', $page);
            $data->getCollection()->transform(function ($item) {
                return $item;
            });
            return $this->successResponsePagination('Lấy danh sách lịch sử đơn hàng thành công!', $data->items(), $data);


        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function my_order_history_detail($id)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Id không tồn tại', null, 404);
            }
            $order_shop = OrderShopModel::with(
                [
                    'shop',
                    'order.user',
                    'order_details.product.category',
                    'voucher_shop',
                    'order.address',
                    'order.address.province',
                    'order.address.district',
                    'order.address.ward',
                    'order.payment_method',
                    'trackings'
                ]
            )->find($id);
            if (!$order_shop || $order_shop->order->user_id != auth('ecommerce')->id()) {
                return $this->errorResponse('Bạn không có quyền xem thông tin đơn hàng này', null, 403);
            }

            return $this->successResponse('Lấy chi tiết đơn hàng thành công!', $order_shop);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function cancel_order($id)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Id không tồn tại', null, 404);
            }
            $order_shop = OrderShopModel::find($id);
            if (!$order_shop || $order_shop->order->user_id != auth('ecommerce')->id()) {
                return $this->errorResponse('Bạn không có quyền xem thông tin đơn hàng này', null, 403);
            }
            $order_shop->status = 'CANCELLED';
            $order_shop->save();
            $order_shop->addTracking('USER', 'CANCELLED');
            return $this->successResponse('Đã hủy đơn hàng thành công!', null);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function verify_payment(Request $request)
    {

        if ($request->input('method') == 'momo') {
            return $this->verify_momo($request);
        } else {
            return $this->verify_vnpay($request);

        }

    }
    public function verify_vnpay($request)
    {

        $vnp_HashSecret = config('services.vnpay.vnp_hash_secret');
        // Lấy tất cả dữ liệu từ request
        $vnpData = $request->all();
        $vnp_ResponseCode = $request->vnp_ResponseCode ?? '';
        // Lấy chuỗi chữ ký gốc từ request và loại bỏ nó khỏi mảng dữ liệu
        $vnpSecureHash = $vnpData['vnp_SecureHash'] ?? '';
        unset($vnpData['vnp_SecureHash']);
        unset($vnpData['vnp_SecureHashType']); // nếu có

        // Chỉ lấy các phần tử có key bắt đầu bằng "vnp_"
        $filteredData = [];
        foreach ($vnpData as $key => $value) {
            if (strpos($key, 'vnp_') === 0) {
                $filteredData[$key] = $value;
            }
        }

        // Sắp xếp theo thứ tự a-z key
        ksort($filteredData);

        // Tạo chuỗi dữ liệu cần hash
        $hashData = '';
        foreach ($filteredData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        // Tạo chữ ký từ chuỗi dữ liệu
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // So sánh với chữ ký từ VNPAY gửi về
        if ($secureHash == $vnpSecureHash) {
            $data = json_decode($request->data, true);

            if ($vnp_ResponseCode == '00') {
                $request = new Request($data);
                return $this->checkout($request);
            } else {
                return response()->json([
                    'message' => 'VNPAY giao dịch không thành công'
                ], 400);
            }


        } else {
            return response()->json([
                'message' => 'Chữ ký không hợp lệ',
                'debug' => [
                    'expected' => $secureHash,
                    'received' => $vnpSecureHash,
                    'hash_data' => $hashData,
                ]
            ], 400);
        }
    }
    public function verify_momo($request)
    {
        $ENDPOINT = config('services.momo.ENDPOINT');
        $PARTNER_CODE = config('services.momo.PARTNER_CODE');
        $ACCESS_KEY = config('services.momo.ACCESS_KEY');
        $SECRET_KEY = config('services.momo.SECRET_KEY');
        $FRONTEND_URL = config('app.common.FRONTEND_URL');

        $data = $request->all();

        $rawHash = "amount=" . $data['amount'] .
            "&extraData=" . $data['extraData'] .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&orderType=" . $data['orderType'] .
            "&partnerCode=" . $data['partnerCode'] .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'] .
            "&transId=" . $data['transId'];

        $signature = hash_hmac("sha256", $rawHash, $SECRET_KEY);
        // $signature === $data['signature'] &&
        if ( $data['resultCode'] == 0) {
            // ✅ Ghi nhận thanh toán
            // Cập nhật đơn hàng, lưu giao dịch...
            $data = json_decode($request->data, true);
            $request = new Request($data);

            return $this->checkout($request);
            // return response()->json(['message' => 'Confirm Success'], 200);
        } else {
            return response()->json(['message' => 'Invalid signature or payment failed'], 400);
        }
    }
}
