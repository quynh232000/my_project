<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingModel extends ApiModel
{
    private $bucket = '';
    public function __construct()
    {
        $this->table            = TABLE_HOTEL_BOOKING_ORDER;
        $this->hidden           = [];
        $this->hidden           = ['created_at', 'created_by', 'updated_at', 'updated_by'];
        parent::__construct();
    }
    protected $guarded          = [];
    protected $casts    =  [
        'price_type' => 'array'
    ];

    public function getItem($params = null, $options = null)
    {

        $result     = [
            'status'        => true,
            'message'       => 'Lấy thông tin thành công!'
        ];
        if ($options['task'] == 'item-by-code') {

            $order  = self::select([
                $this->table . '.code',
                $this->table . '.hotel_id',
                $this->table . '.room_id',
                $this->table . '.price_type_id',
                $this->table . '.price_type',
                $this->table . '.final_money',
                $this->table . '.total_price',
                $this->table . '.total_discount',
                $this->table . '.total_surcharge',
                $this->table . '.quantity',
                $this->table . '.adt',
                $this->table . '.chd',
                $this->table . '.depart_date',
                $this->table . '.return_date',
                $this->table . '.duration',
                $this->table . '.currency',
                $this->table . '.status',
            ])
                ->with([
                    'hotel:id,slug,name,accommodation_id,stars',
                    'hotel.accommodation:id,name',
                    'hotel.policy_others.policy_name:id,name',
                    'hotel.policy_generals.policy_name:id,name',
                    'hotel.policy_cancellations' => fn($q) => $q->where('is_global', true),
                    'hotel.policy_cancellations.policy_cancel_rules',
                    'hotel.policy_cancellations.price_types:id,name,policy_cancel_id',
                    'room:id,name,area,direction_id,bed_type_id,bed_quantity,breakfast,smoking',
                    'room.direction:id,name',
                    'room.bed_type:id,name'
                ])
                ->where('code', $params['code'])
                ->first();
            $order->room->capacity_avg = [
                'adt' => (int)ceil(($order->adt ?? 1) / $order->quantity),
                'chd' => (int)ceil(($order->chd ?? 0) / $order->quantity)
            ];
            return $order;
        }
        if ($options['task'] == 'item-info') {
            $response = self::getDataValide($params);

            if ($response['status'] == false) {
                return $response;
            }
            $data                   = $response['data'];

            $result['data']         = [
                ...$data['data_order'],
                'room'              => $data['room'],
                'hotel'             => $data['hotel'],
                'daily_prices'      => $data['daily_prices'],
            ];



            return $result;
        }
        return $result;
    }
    public function saveItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'add-item') {

            $response = self::getDataValide($params);
            // return $response;
            if ($response['status'] == true) {
                // create order start ===============
                return self::createOrder($response['data'], $params['payment_method'], [
                    'return_url' => $params['return_url'] ?? ''
                ]);
            }
            return $response;
        }
    }
    private function getDataValide($params)
    {
        $info             = $params['info'];
        $info['adt']      = (int)($info['adt'] ?? 1);
        $info['chd']      = (int)($info['chd'] ?? 0);
        $info['quantity'] = (int)($info['quantity'] ?? 1);
        $info['capacity'] = (int)ceil(($info['adt'] + $info['chd']) / $info['quantity']); //sức chứa trung bình mỗi phòng
        $info['end']      =  Carbon::parse($info['date_end'])->subDay()->format('Y-m-d'); // trừ đi 1 ngày
        $period           = CarbonPeriod::create($info['date_start'], $info['end']);
        $info['duration'] =  $period->count();
        $expectedDates                      = collect($period)->map(fn($date) => $date->format('Y-m-d'))->toArray();

        // check lấy dữ liệu thô
        $withRelation               = [
            'hotel:id,slug,name,accommodation_id,stars,image,time_checkin,time_checkout',
            'hotel.accommodation:id,name',
            'hotel.location',
            'hotel.policy_others.policy_name:id,name',
            'hotel.policy_generals.policy_name:id,name',
            'hotel.policy_cancellations' => fn($q) => $q->where('is_global', true),
            'hotel.policy_cancellations.policy_cancel_rules',
            'hotel.policy_cancellations.price_types:id,name,policy_cancel_id',
            'direction:id,name',
            'bed_type:id,name',
            'images' => fn($q) => $q->first(),
            'price_details' => function ($q) use ($info) {
                $q->where(function ($query) {
                    $query->where(TABLE_HOTEL_PRICE_DETAIL . '.status', '!=', 'close')
                        ->orWhereNull(TABLE_HOTEL_PRICE_DETAIL . '.status');
                })
                    ->whereBetween(TABLE_HOTEL_PRICE_DETAIL . '.date', [$info['date_start'], $info['end']]);
            },
            'price_details.price_detail_price_types' => fn($q) => $q->where(TABLE_HOTEL_PRICE_DETAIL_PRICE_TYPE . '.price_type_id', $info['price_type_id']),
            'price_details.price_detail_price_types.price_type',
            'price_settings' => fn($q) => $q->where([
                TABLE_HOTEL_PRICE_SETTING . '.price_type_id'  => $info['price_type_id'],
                TABLE_HOTEL_PRICE_SETTING . '.status'         => 'active',
                TABLE_HOTEL_PRICE_SETTING . '.capacity'       => $info['capacity'],
            ]),
            'promotions' => function ($q) use ($info) {
                $q->where('status', 'active')
                    ->whereHas('price_types', function ($query) use ($info) {
                        $query->where(TABLE_HOTEL_PROMOTION_PRICE_TYPE . '.price_type_id', $info['price_type_id']);
                    });
            },
        ];

        $query                      = RoomModel::with($withRelation)->where([
            'id'        => $info['room_id'],
            'status'    => 'active'
        ]);

        $query                      = $query->availableRoom($info);

        $room                       = $query->first();

        if (!$room) {
            return [
                'status'    => false,
                'message'   => 'Không tìm thấy phòng phù hợp với yêu cầu của bạn!',
            ];
        }
        // ====== Khởi tạo dữ liệu trả về ======
        $params['order_from'] = $params['order_from'] ?? 'HW';
        $data_order   = [
            'code'              =>  time() . rand(100, 999),
            'price_type_id'     => $info['price_type_id'],
            'final_money'       => 0,
            'total_price'       => 0,
            'total_discount'    => 0,
            'total_surcharge'   => 0,
            'duration'          => $info['duration'],
            'quantity'          => $info['quantity'],
            'adt'               => $info['adt'],
            'chd'               => $info['chd'],
            'depart_date'       => Carbon::parse($info['date_start'])->format('Y-m-d'),
            'return_date'       => Carbon::parse($info['date_end'])->format('Y-m-d'),
            'room_id'           => $info['room_id'],
            'hotel_id'          => $room->hotel_id,
            'currency'          => $params['currency'] ?? 'VND',
            'order_from'        => $params['order_from'],
            'ip'                => $params['ip'] ?? request()->ip(),
        ];
        // ====== Kết thúc khởi tạo dữ liệu trả về ======
        // Lấy giá phụ thu
        $surcharge          = $room->price_settings->first()->price ?? 0;
        if ($info['capacity'] < $room->standard_guests) {
            $surcharge      = -abs($surcharge);
        }

        //  kiểm tra loại giá có hợp lệ không
        $daily_prices       = [];
        if ($room->price_details->isEmpty()) {
            if ($info['price_type_id'] != 0) {
                return [
                    'status'    => false,
                    'message'   => 'Không tìm thấy loại giá phù hợp với yêu cầu của bạn! Không tìm thấy giá setup nào cho loại giá này',
                ];
            }
            // Nếu không có loại giá thì lấy giá chuẩn của phòng; giá tiêu chuẩn không có các chính sách
            foreach ($period as $date) {
                $data           = [
                    'price_type_id'         => 0,
                    'price'                 => $room->price_standard,
                    'date'                  => Carbon::parse($date)->format('Y-m-d'),
                    'surcharge'              => $surcharge
                ];

                $daily_price    = self::builDailyPrice($data);
                $daily_prices[] = $daily_price;
                self::sumPriceFinal($data_order, $daily_price);
            }
        } else if ($info['price_type_id'] != 0) {
            // lọc price_details đủ số phòng trống
            $room->price_details = $room->price_details->filter(function ($detail) use ($room, $info) {
                if (!is_null($detail->quantity)) {
                    return ($detail->quantity - $detail->room_booked) >= $info['quantity'];
                }
                return ($room->quantity - $detail->room_booked) >= $info['quantity'];
            });
            if ($room->price_details->count() != $info['duration']) {
                return [
                    'status'    => false,
                    'message'   => 'Không tìm thấy loại giá phù hợp với yêu cầu của bạn! Không đủ số lượng phòng',
                ];
            } else {
                // Nếu có loại giá thì lấy loại giá phù hợp với yêu cầu

                $data_order['price_type']          = PriceTypeModel::with('policy_cancel.policy_cancel_rules')->find($info['price_type_id']);
                // - Lấy chính sách hoàn hủy, chinh sách trẻ em
                $data_order['price_type']['policy_cancel']      = $data_order['price_type']->policy_cancel_apply ?? null;
                $data_order['price_type']['policy_children']    = $data_order['price_type']->policy_children_apply ?? null;

                foreach ($room->price_details as $priceDetail) {
                    $price      = $priceDetail->price_detail_price_types->first()->price ?? 0;
                    $promotion  = self::getPromotionDailyDay([...$info, 'promotions' => $room->promotions], $priceDetail->date, $price);
                    if (in_array($priceDetail->date, $expectedDates)) {
                        $data   = [
                            'price_type_id'         => $info['price_type_id'],
                            'price'                 => $price,
                            'date'                  => $priceDetail->date,
                            'room_booked_current'   => $priceDetail->room_booked ?? 0,
                            'promotions'            => $promotion['promotion'],
                            'discount_amount'       => $promotion['discount_amount'],
                            'surcharge'              => $surcharge
                        ];
                        $daily_price = self::builDailyPrice($data);
                        $daily_prices[] = $daily_price;
                        self::sumPriceFinal($data_order, $daily_price);
                    }
                }
            }
        } else {
            // Nếu loại là là 0; là giá tiêu chuẩn thì lấy những ngày có setup giá, không có setup giá thì lấy giá tiêu chuẩn của phòng
            // nếu không có trong price_detail trong ngày đó thì lấy giá base bên room
            foreach ($room->price_details as $priceDetail) {
                if (in_array($priceDetail->date, $expectedDates)) {
                    $data           = [
                        'price_type_id'         => 0,
                        'price'                 => $priceDetail->price_detail_price_types->first()->price ?? 0,
                        'date'                  => $priceDetail->date,
                    ];

                    $daily_price = self::builDailyPrice($data);
                    $daily_prices[] = $daily_price;
                    self::sumPriceFinal($data_order, $daily_price);
                } else {
                    $data           = [
                        'price_type_id'         => 0,
                        'price'                 => $room->price_standard,
                        'date'                  => Carbon::parse($priceDetail->date)->format('Y-m-d'),
                        'surcharge'              => $surcharge
                    ];
                    $daily_price = self::builDailyPrice($data);
                    $daily_prices[] = $daily_price;
                    self::sumPriceFinal($data_order, $daily_price);
                }
            }
        }
        // kiểm tra số lượng phòng còn trống
        if (empty($daily_prices)) {
            return [
                'status'    => false,
                'message'   => 'Không tìm thấy loại giá phù hợp với yêu cầu của bạn! Không tìm thấy giá mỗi ngày',
            ];
        }

        // Tính tổng tiền

        $data_order['total_surcharge']  = $data_order['total_surcharge'] * $data_order['quantity'];
        $data_order['total_price']      = $data_order['total_price'] * $data_order['quantity'];
        $data_order['total_discount']   = $data_order['total_discount'] * $data_order['quantity'];
        $data_order['final_money']      = $data_order['total_price'] - $data_order['total_discount'] + $data_order['total_surcharge'];

        $hotel                          = $room->hotel;
        unset($room->hotel);
        $params = [
            ...$params,
            'room'          => $room,
            'hotel'         => $hotel,
            'daily_prices'  => $daily_prices,
            'data_order'    => $data_order
        ];
        return [
            'status'    => true,
            'message'   => 'Lấy dữ liệu thành công!',
            'data'      => $params
        ];
    }
    private function builDailyPrice($params)
    {
        return  [
            // 'price_type_id'         => $params['price_type_id'],
            'price'                 => $params['price'],
            'date'                  => Carbon::parse($params['date'])->format('Y-m-d'),
            'surcharge'             => $params['surcharge'] ?? 0,
            'room_booked_current'   => $params['room_booked_current'] ?? 0,
            'discount_amount'       => $params['discount_amount'] ?? 0,
            'final_price'           => $params['price'] - ($params['discount_amount'] ?? 0) + ($params['surcharge'] ?? 0),
            'promotions'            => json_encode($params['promotions'] ?? []),
        ];
    }
    private function getPromotionDailyDay($params, $date, $basePrice)
    {

        $promotions                 = collect($params['promotions']);

        if ($promotions->isEmpty()) {
            return [
                'discount_amount'   => 0,
                'promotion'         => null
            ];
        }
        $validPromotions = collect($promotions)->filter(function ($promo) use ($date) {
            return $promo['start_date'] <= $date &&
                (empty($promo['end_date']) || $promo['end_date'] >= $date);
        });
        // Tách voucher cộng dồn và không cộng dồn

        $stackable          = $validPromotions->filter(fn($p) => $p['is_stackable']);
        $nonStackable       = $validPromotions->filter(fn($p) => !$p['is_stackable']);

        // Tính tổng mức giảm từ các voucher cộng dồn
        $stackableDiscount  = 0;
        $stackableApplied   = [];

        foreach ($stackable as $promo) {
            $discount       = $this->get_promo_discount_amount([...$params, 'date' => $date], $promo, $basePrice);
            if ($discount > 0) {
                $stackableDiscount  += $discount;
                $stackableApplied[] = $promo;
            }
        }

        // Tính mức giảm từng non-stackable
        $nonStackableOptions    = $nonStackable->map(function ($promo) use ($basePrice, $params, $date) {
            return [
                'promo'     => $promo,
                'discount'  => $this->get_promo_discount_amount([...$params, 'date' => $date], $promo, $basePrice),
            ];
        });

        $bestNonStackable       = $nonStackableOptions
            ->sortByDesc('discount')
            ->first();

        // So sánh hai phương án
        if ($stackableDiscount >= ($bestNonStackable['discount'] ?? 0)) {
            return  [
                'discount_amount'        => $stackableDiscount,
                'promotion'    => $stackableApplied,
            ];
        }
        return      [
            'discount_amount'        => $bestNonStackable['discount'] ?? 0,
            'promotion'    => $bestNonStackable ? [$bestNonStackable['promo']] : [],
        ];
    }
    private function get_promo_discount_amount($params, $promo, $basePrice)
    {
        $type       = $promo['type']; // Ví dụ: first_night, each_nights
        $value      = floatval($promo['value']);

        switch ($type) {
            case 'first_night':
                // Chỉ áp dụng nếu ngày đang xét chính là đêm đầu tiên
                if ($params['date'] === $params['date_start']) {
                    return ($value / 100) * $basePrice;
                }
                return 0;

            case 'each_nights':
                // Áp dụng cho mỗi đêm trong khoảng từ date_start -> date_end
                return ($value / 100) * $basePrice;

            case 'day_of_weeks':
                $date       = Carbon::parse($params['date']);
                $dayOfWeek  = $date->dayOfWeekIso;

                // Tìm phần tử khớp với day_
                // Truy cập value nếu cần
                $value      = $promo['day_' . $dayOfWeek] ?? 0;
                return ($value / 100) * $basePrice;
            default:
                return 0;
        }
    }
    private function sumPriceFinal(&$data_order, $daily_price)
    {
        $data_order['total_price']       += $daily_price['price'];
        $data_order['total_discount']    += $daily_price['discount_amount'] ?? 0;
        $data_order['total_surcharge']   += $daily_price['surcharge'] ?? 0;
        $data_order['final_money']       += $daily_price['final_price'];
    }

    private function createOrder($params, $payment_method, $options = null)
    {
        DB::beginTransaction();

        try {
            // dd($params['deputy']);
            // Tạo đơn hàng
            $order                  = self::create($this->prepareParams([...$params['data_order'], 'payment_method' => $payment_method, 'user_id' => auth('hms')->id()]));

            // Lưu deputy
            $data_deputy            = [
                ...$params['deputy'],
                'order_id'        => $order['id'],
                'special_require' => isset($params['deputy']['special_require']) ? json_encode($params['deputy']['special_require'] ?? []) : null
            ];
            BookingDeputyModel::insert($this->prepareParams($data_deputy));

            // Lưu bill
            if ($params['bill'] ?? false) {

                $data_bill          = [...$params['bill'], 'order_id' => $order['id']];
                BookingBillingModel::insert($this->prepareParams($data_bill));
            }

            // Lưu daily price
            $dataDailyPrices        = [];
            $quantity_booked        = [];
            foreach ($params['daily_prices'] as $key => $item) {

                $quantity_booked[]  = [
                    'room_id'               => $params['data_order']['room_id'],
                    'date'                  => $item['date'],
                    'room_booked'           => (int)($params['data_order']['quantity'] + $item['room_booked_current'])
                ];

                unset($item['room_booked_current']);
                $dataDailyPrices[]  = [...$item, 'order_id' => $order['id']];
            }

            BookingDailyPriceModel::insert($this->prepareParams($dataDailyPrices));

            // Trừ số lượng phòng (room.quantity)
            PriceDetailModel::upsert(
                $quantity_booked,
                ['room_id', 'date'],
                ['room_id', 'date', 'room_booked']
            );

            // Thanh toán
            // Gửi mail
            $dataRes = [
                'code'  => $order->code ?? $params['data_order']['code']
            ];
            $dataPayment = [
                'order_code'    => $order->code,
                'total'         => $params['data_order']['final_money'],
                'return_url'    => $options['return_url'] ?? ''
            ];
            switch ($payment_method) {
                case 'vnpay':
                    $dataRes['pay_url'] = self::checkoutVnpay($dataPayment);
                    break;
                case 'momo':
                    $dataRes['pay_url'] = self::checkoutMomo($dataPayment);
                    break;

                default:
                    # code...
                    break;
            }

            DB::commit();
            return  [
                'status'    => true,
                'message'   => 'Tạo đơn hàng thành công!',
                'data'      => $dataRes
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Create order failed: ' . $e->getMessage(), [
                'params'    => $params,
                'trace'     => $e->getTraceAsString()
            ]);

            return  [
                'status'    => false,
                'message'   => 'Đã có lỗi xảy ra khi tạo đơn hàng!',
                'data'      => $e->getMessage()
            ];
        }
    }
    public function hotel()
    {
        return $this->belongsTo(HotelModel::class, 'hotel_id', 'id');
    }
    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }
    public function checkoutVnpay($params)
    {
        $VNP_TMN_CODE       = config('services.vnpay.vnp_tmn_code');
        $VNP_HASH_SECRET    = config('services.vnpay.vnp_hash_secret');
        $VNP_URL            = config('services.vnpay.vnp_url');
        $VNP_RETURN_URL     = $params['return_url'] ?? config('services.vnpay.vnp_return_url');

        $startTime  = date("YmdHis");
        $expire     = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef     =  $params['order_code'] ?? uniqid(); //$params['order_code']; // mã đơn hàng duy nhất
        $vnp_OrderInfo  = "Payment for order " . $vnp_TxnRef;
        $vnp_Amount     = intval($params['total']) * 100; // số tiền *100
        $vnp_Locale     = 'vn';
        $vnp_BankCode   = $params['bank_name'] ?? '';
        $vnp_IpAddr     = request()->ip(); // thay cho $_SERVER để chuẩn proxy

        $inputData = [
            "vnp_Version"   => "2.1.0",
            "vnp_TmnCode"   => $VNP_TMN_CODE,
            "vnp_Amount"    => $vnp_Amount,
            "vnp_Command"   => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode"  => "VND",
            "vnp_IpAddr"    => $vnp_IpAddr,
            "vnp_Locale"    => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef . '-' . $vnp_OrderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $VNP_RETURN_URL, // return url đầy đủ
            "vnp_TxnRef"    => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        ];

        // Nếu có chọn bank thì thêm vào
        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sắp xếp key theo alphabet
        ksort($inputData);

        // Tạo query & hashdata
        $query = [];
        $hashdataArr = [];
        foreach ($inputData as $key => $value) {
            $query[]      = urlencode($key) . "=" . urlencode($value);
            $hashdataArr[] = $key . "=" . $value; // không urlencode key
        }

        $queryString = implode('&', $query);
        $hashdata    = implode('&', $hashdataArr);

        // Tạo secure hash
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $VNP_HASH_SECRET);

        // Build URL cuối
        $paymentUrl = $VNP_URL . "?" . $queryString . '&vnp_SecureHash=' . $vnpSecureHash;

        return $paymentUrl;
    }
    public function checkoutMomo($params)
    {
        $ENDPOINT = config('services.momo.ENDPOINT');
        $PARTNER_CODE = config('services.momo.PARTNER_CODE');
        $ACCESS_KEY = config('services.momo.ACCESS_KEY');
        $SECRET_KEY = config('services.momo.SECRET_KEY');
        $FRONTEND_URL = config('app.common.FRONTEND_URL');

        try {
            $orderInfo = "Thanh toán đơn hàng Quin";
            $amount = intval($params['total']);
            $orderId = $params['order_code']; //random_int(00, 99999);
            $extraData = "";

            $return_url = $FRONTEND_URL . $params['return_url'];
            $requestId = time() . "";
            $requestType = "payWithATM";
            // $requestType = "captureWallet";
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $ACCESS_KEY .
                "&amount=" . $amount .
                "&extraData=" . $extraData .
                "&ipnUrl=" . $return_url .
                "&orderId=" . $orderId .
                "&orderInfo=" . $orderInfo .
                "&partnerCode=" . $PARTNER_CODE .
                "&redirectUrl=" . $return_url .
                "&requestId=" . $requestId .
                "&requestType=" . $requestType;

            $signature = hash_hmac("sha256", $rawHash, $SECRET_KEY);
            $data = array(
                'partnerCode' => $PARTNER_CODE,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $return_url,
                'ipnUrl' => $return_url,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );

            // check url
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($ENDPOINT, $data);

            if ($response->successful()) {
                $resData = $response->json();
                if ($resData['resultCode'] == 0) {
                    return $resData['payUrl'];
                } else {
                    return false;
                }
            } else {
                Log::error('Lỗi call momo endpoint: ' . $response->json());
                return false;
            }
        } catch (Exception $e) {
            Log::error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return false;
        }
    }
}
