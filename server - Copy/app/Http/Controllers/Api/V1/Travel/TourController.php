<?php

namespace App\Http\Controllers\Api\V1\Travel;

use App\Models\Api\V1\Travel\Like;
use App\Models\Api\V1\Travel\Order;
use App\Models\Api\V1\Travel\OrderDetail;
use App\Models\Api\V1\Travel\ProcessTour;
use App\Models\Api\V1\Travel\Product;
use App\Models\Api\V1\Travel\Response;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use Illuminate\Support\Facades\Mail;

class TourController extends Controller
{


    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'thumnail' => 'required|image',
            'images' => 'required',
            'type' => 'required',
            'category' => 'required',
            'price' => 'required',
            'price_child' => 'required',
            'price_baby' => 'required',
            'percent_sale' => 'required',
            'additional_fee' => 'required',
            "province_start_id" => 'required',
            "province_end_id" => 'required',
            'number_of_day' => 'required',
            'tour_pakage' => 'required',
            'quantity' => 'required',
            'date_start' => 'required',
            'time_start' => 'required',
            'transportation' => 'required'
        ]);
        if ($validate->fails()) {
            return Response::json(false, 'Missing parameters', $validate->errors());
        }
        try {
            $images = [];
            if ($request->hasFile('images')) {
                if (count($request->images) > 4) {
                    return Response::json(false, 'Images must not exceed 4 items');
                }
                foreach ($request->images as $image) {
                    $images[] = $image->store('tour', 'public');
                    // $images[] = Cloudinary::upload($image->getRealPath())->getSecurePath();
                }
            }
            $thumnail = "";
            if ($request->hasFile('thumnail')) {
                $thumnail = $request->file('thumnail')->store('tour', 'public');
                // $thumnail = Cloudinary::upload($request->thumnail->getRealPath())->getSecurePath();
            }

            $tour = Product::create([
                'uuid' => Str::uuid(),
                'slug' => $request->title,
                'title' => $request->title,
                'thumnail' => $thumnail,
                'country_id' => $request->country_id ?? 232,
                'images' => json_encode($images),
                'type' => $request->type,
                'category' => $request->category,
                'price' => $request->price,
                'price_child' => $request->price_child,
                'price_baby' => $request->price_baby,
                'percent_sale' => $request->percent_sale,
                'additional_fee' => $request->additional_fee,
                "province_start_id" => $request->province_start_id,
                "province_end_id" => $request->province_end_id,
                'number_of_day' => $request->number_of_day,
                'tour_pakage' => $request->tour_pakage,
                'quantity' => $request->quantity,
                'date_start' => $request->date_start,
                'time_start' => $request->time_start,
                'transportation' => $request->transportation,
                'tourguide_id' => auth('api')->user()->id,
            ]);
            $tour->slug = Str::slug($request->title) . '_' . $tour->id;
            $tour->save();
            // create process tour

            $processTours = [];
            if ($request->has(['date', 'title_process', 'content'])) {
                if (count($request->date) != count($request->title_process) || count($request->date) != count($request->content)) {
                    return Response::json(false, 'Missing parameters of precess detail');
                }
                foreach ($request->date as $key => $value) {
                    $processTours[] = ProcessTour::create([
                        'product_id' => $tour->id,
                        'date' => $value,
                        'title' => $request->title_process[$key],
                        'content' => $request->content[$key]
                    ]);
                }
            }
            $tour['process_tour'] = $processTours;

            return Response::json(true, 'Tour created successfully', $tour);
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while creating tour ', $e->getMessage());
        }
    }



    /**
     * @OA\Get(

     *
     *      path="/api/tour/list_tour",
     *      operationId="list_tour",
     *      tags={"Tour"},
     *      summary="Get list list_tour",
     *      description="Returns list list_tour information",
     *
     *      @OA\Parameter(
     *         description="page of tour to return",
     *         in="query",
     *         name="page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="limit of tour to return",
     *         in="query",
     *         name="limit",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="key of tour to return (type,category,province_start_id,province_end_id,...)",
     *         in="query",
     *         name="key",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="value of tour to return (1-4,1000-2000,hotel,...)",
     *         in="query",
     *         name="value",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *
     *
     * )
     */
    public function list_tour(Request $request)
    {
        try {
            $page = $request->page ?? 1;
            $limit = $request->limit ?? 10;

            $key = $request->key;
            $value = $request->value;
            $sort = $request->sort;

            $query = Product::where('is_show', 1);

            $query = $this->applyFilters($query, $key, $value);

            $query = $this->applySorting($query, $sort);
            $query->with([
                'country',
                'province_start' => function ($query) {
                    $query->select('id', 'name');
                },
                'province_end' => function ($query) {
                    $query->select('id', 'name');
                }
            ]);


            $tours = $query->paginate($limit, ['*'], 'page', $page);

            // Add additional data to each tour
            $tours->getCollection()->transform(function ($tour) {
                $user_id = auth('api')->id() ?? null;
                $tour->is_like = $tour->is_like($user_id);
                $tour->like_count = $tour->like_count();
                return $tour;
            });



            return Response::json(true, 'Get list tour successfully', $tours->items(), [
                'current_page' => $tours->currentPage(),
                'last_page' => $tours->lastPage(),
                'per_page' => $tours->perPage(),
                'total' => $tours->total(),
                'next_page_url' => $tours->nextPageUrl(),
                'prev_page_url' => $tours->previousPageUrl(),
            ]);
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while listing tour', $e->getMessage());
        }
    }

    /**
     * @OA\Get(

     *
     *      path="/api/tour/filterproducts",
     *      operationId="filterproducts",
     *      tags={"Tour"},
     *      summary="Get filter list list_tour",
     *      description="Returns list list_tour information",
     *
     *      @OA\Parameter(
     *         description="page of tour to return",
     *         in="query",
     *         name="page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="limit of tour to return",
     *         in="query",
     *         name="limit",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="inside, ouside",
     *         in="query",
     *         name="type",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="province_id)",
     *         in="query",
     *         name="province_start_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Parameter(
     *         description="province_id)",
     *         in="query",
     *         name="province_end_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),@OA\Parameter(
     *         description="0-4, 3)",
     *         in="query",
     *         name="number_of_day",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),@OA\Parameter(
     *         description="2024-08-23",
     *         in="query",
     *         name="date_start",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),@OA\Parameter(
     *         description="10000-450000, 3000000)",
     *         in="query",
     *         name="price",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),@OA\Parameter(
     *         description="('luxury','standard','affordable','saving')",
     *         in="query",
     *         name="tour_pakage",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),@OA\Parameter(
     *         description="(created_at-asc,desc)",
     *         in="query",
     *         name="order_by",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *
     *
     * )
     */
    public function filterProducts(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $type = $request->type;
            $province_start_id = $request->province_start_id;
            $province_end_id = $request->province_end_id;
            $number_of_day = $request->number_of_day;
            $date_start = $request->date_start;
            $price = $request->price;
            $tour_pakage = $request->tour_pakage;
            $order_by = $request->order_by;

            $query = Product::where('is_show', 1);

            if (!empty($type)) {
                $query->where('type', $type);
            }
            if (!empty($province_start_id)) {
                $query->where('province_start_id', $province_start_id);
            }
            if (!empty($province_end_id)) {
                $query->where('province_end_id', $province_end_id);
            }
            if (!empty($number_of_day)) {
                $range = explode('-', $number_of_day);
                if (count($range) === 2) {
                    $query->whereBetween('number_of_day', [$range[0], $range[1]]);
                } else {
                    $query->where('number_of_day', '>=', $number_of_day);
                }
            }
            if (!empty($date_start)) {
                $query->where('date_start', 'LIKE', '%' . $date_start . '%');
            }
            if (!empty($price)) {
                $range = explode('-', $price);
                if (count($range) === 2) {
                    $query->whereBetween('price', [$range[0], $range[1]]);
                } else {
                    $query->where('price', '>=', $price);
                }
            }
            if (!empty($tour_pakage)) {
                $query->where('tour_pakage', 'LIKE', '%' . $tour_pakage . '%');
            }

            if (!empty($order_by)) {
                $sortArr = explode('-', $order_by);
                if (count($sortArr) === 2) {
                    $query->orderBy($sortArr[0], $sortArr[1]);
                } else {
                    $query->orderBy($order_by, 'DESC');
                }
            }
            $query->with([
                'country',
                'province_start' => function ($query) {
                    $query->select('id', 'name');
                },
                'province_end' => function ($query) {
                    $query->select('id', 'name');
                }
            ]);
            $tours = $query->paginate($limit, ['*'], 'page', $page);

            // Add additional data to each tour
            $tours->getCollection()->transform(function ($tour) {
                $user_id = auth('api')->id();
                $tour->is_like = $tour->is_like($user_id);
                $tour->like_count = $tour->like_count();
                return $tour;
            });
            return Response::json(true, 'Get list tour successfully', $tours->items(), [
                'current_page' => $tours->currentPage(),
                'last_page' => $tours->lastPage(),
                'per_page' => $tours->perPage(),
                'total' => $tours->total(),
                'next_page_url' => $tours->nextPageUrl(),
                'prev_page_url' => $tours->previousPageUrl(),
            ]);
        } catch (Exception $e) {
            return Response::json(false, "Error: " . $e->getMessage());
        }
    }
    private function applyFilters($query, $key, $value)
    {
        if ($key && $value) {
            switch ($key) {
                case 'number_of_day':
                case 'price':
                    return $this->applyRangeFilter($query, $key, $value);
                default:
                    return $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }

        return $query;
    }

    private function applyRangeFilter($query, $key, $value)
    {
        $range = explode('-', $value);
        if (count($range) > 1) {
            return $query->whereBetween($key, $range);
        } else {
            return $query->where($key, '>=', $value);
        }
    }

    private function applySorting($query, $sort)
    {
        if ($sort) {
            $sortArr = explode('-', $sort);
            if (count($sortArr) == 2) {
                return $query->orderBy($sortArr[0], $sortArr[1]);
            } else {
                return $query->orderBy($sort, 'DESC');
            }
        }

        return $query;
    }

    /**
     * @OA\Get(

     *
     *      path="/api/tour/{slug}",
     *      operationId="get tour detail",
     *      tags={"Tour"},
     *      summary="Get Tour Information",
     *      description="Returns tour information",
     *    @OA\Parameter(
     *          name="slug",
     *          description="Tour slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *
     *
     * )
     */
    public function getDetail($slug)
    {
        try {
            if (!$slug) {
                return Response::json(false, 'Missing parameters Slug', null);
            }
            $tour = Product::where('slug', $slug)
                ->with(['country', 'province_start', 'province_end', 'process_tour', 'tourguide'])
                ->first();

            if (!$tour) {
                return Response::json(false, 'Tour not found', null);
            }
            $tour->images = json_decode($tour->images);
            $tour->like_count = $tour->like_count();

            $user_id = auth('api')->id() ?? null;
            $tour->is_like = $tour->is_like($user_id);
            return Response::json(true, 'Get tour detail successfully', $tour);
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while getting tour detail', $e->getMessage());
        }
    }


    /**
     * @OA\Post(
     *      path="/api/order/checkout",
     *      operationId="checkout",
     *      tags={"Order"},
     *      summary="create an new order",
     *      description="Returns an order ",
     *
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="full_name",
     *                     description="Your full name",
     *                     type="string",
     *                      example="Nguyen van a"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="Your email address",
     *                     type="string",
     *                      example="test@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="Your address",
     *                   example="Q12, Tp.HCM",
     *                     type="string"
     *                 ),
     *                @OA\Property(
     *                     property="phone_number",
     *                     description="confirm password",
     *                     type="integer",
     *                     example="09234534",
     *                 ), @OA\Property(
     *                     property="quantity",
     *                     description="Quantity of adult",
     *                   example=1,
     *                     type="integer"
     *                 ), @OA\Property(
     *                     property="quanity_child",
     *                     description="Quantity of child",
     *                   example=1,
     *                     type="integer"
     *                 ), @OA\Property(
     *                     property="quanity_baby",
     *                     description="Quantity of baby",
     *                   example=1,
     *                     type="integer"
     *                 ), @OA\Property(
     *                     property="tour_id",
     *                     description="Tour id in the database",
     *                   example=1,
     *                     type="integer"
     *                 ), @OA\Property(
     *                     property="note",
     *                     description="Your note",
     *
     *                     type="string"
     *                 ),
     *
     *             )
     *         )
     *     ),
     *      @OA\Response(response="405", description="Invalid input"),
     * )
     */
    public function checkout(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required|email|string',
                'full_name' => 'required|string',
                'address' => 'required|string',
                'phone_number' => 'required|string',
                'quantity' => 'required|integer',
                'tour_id' => 'required|integer'
            ]);

            if ($validate->fails()) {
                return Response::json(false, 'Validation failed', $validate->errors());
            }

            $quantity_child = $request->quantity_child ?? 0;
            $quantity_baby = $request->quantity_baby ?? 0;
            $tour = Product::where('id', $request->tour_id)->with(['country', 'province_start', 'province_end', 'process_tour', 'tourguide'])
                ->first();
            if (!$tour) {
                return Response::json(false, 'tour_id not found!', null);
            }
            if ($tour->quantity < ($request->quantity + $quantity_child + $quantity_baby)) {
                return Response::json(false, 'Not enough quantity', null);
            }
            $subtotal = $tour->price * $request->quantity + $tour->price_child * $quantity_child
                + $tour->price_baby * $quantity_baby;
            $total = $subtotal + $tour->additional_fee;

            $order = Order::create([
                'email' => $request->email,
                'full_name' => $request->full_name,
                'address' => $request->address,
                'status' => 'success',
                'phone_number' => $request->phone_number,
                'payment_status' => 0,
                'subtotal' => $subtotal,
                'total' => $total,
                'note' => $request->note ?? "",
            ]);
            $order_detail = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $tour->id,
                'quantity' => $request->quantity,
                'quantity_child' => $quantity_child,
                'quantity_baby' => $quantity_baby,
                'additional_fee' => $tour->additional_fee,
                'price' => $tour->price,
                'price_child' => $tour->price_child,
                'price_baby' => $tour->price_baby,
            ]);

            // send mail
            $data['email'] = $request->email;
            $data['title'] = "Xác nhận đặt Tour tại Quin Travel";
            $data['tour'] = $tour;
            $data['subtotal'] = $total;
            $data['total'] = $total;
            $data['order'] = $order;
            $data['order_detail'] = $order_detail;
            Mail::send("mail.api.v1.travel.mail", ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            $order['order_detail'] = $order_detail;
            $order['order_detail']['product'] = $tour;
            return Response::json(true, 'Order successfully created', $order);
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while checkout', $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/tour/like/{tour_id}",
     *      operationId="like_tour",
     *      tags={"Tour"},
     *      summary="Like or unlike a tour",
     *      description="Returns status",
     *
     *      security={{
     *         "bearer": {}
     *     }},
     *     @OA\Parameter(
     *          name="tour_id",
     *          description="tour_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *
     *
     * )
     */
    public function like($tour_id)
    {
        try {
            if (!$tour_id) {
                return Response::json(false, 'Missing parameters tour_id', null);
            }
            $tour = Product::find($tour_id);
            if (!$tour) {
                return Response::json(false, 'Tour not found', null);
            }
            $check = Like::where(['user_id' => auth('api')->id(), 'product_id' => $tour_id])->first();
            if ($check) {
                $check->delete();
                return Response::json(true, 'Unlike successfully', null);
            } else {
                Like::create(['user_id' => auth('api')->id(), 'product_id' => $tour_id]);
                return Response::json(true, 'Like successfully', null);
            }
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while like', $e->getMessage());
        }
    }

    /**
     * @OA\Get(

     *
     *      path="/api/order/{id}",
     *      operationId="orderdetail",
     *      tags={"Order"},
     *      summary="Get order detail Information",
     *      description="Returns ordertail information",
     *
     *      security={{
     *         "bearer": {}
     *     }},
     *  @OA\Parameter(
     *          name="id",
     *          description="get order detaiil by order id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *
     *
     * )
     */
    public function order_detail($id)
    {
        try {
            $order = Order::where('id', $id)->with('order_detail.product.tourguide')->first();
            if (!$order) {
                return Response::json(false, 'Order not found', null);
            }
            return Response::json(true, 'Get order detail successfully', $order);
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while getting order detail', $e->getMessage());
        }
    }



    public function history()
    {
        try {
            $orders = Order::where('email', auth('travel')->user()->email)->with('order_detail.product.tourguide')->latest()->limit(20)->get();
            return Response::json(true, 'Get order history successfully', $orders);
        } catch (Exception $e) {
            return Response::json(false, 'An error occurred while getting order history', $e->getMessage());
        }
    }

    private $VNP_TMN_CODE = 'RIIFM9FX';
    private $VNP_HASH_SECRET = 'YETJQVOMBAKTQRBNBOQVCXFOQGDVJJPA';
    private $VNP_URL = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    private $VNP_RETURN_URL = 'http://localhost:4200/';
    public function checkoutVnpay(Request $request)
    {

        try {
            $startTime = date("YmdHis");
            $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
            $vnp_TmnCode = $this->VNP_TMN_CODE;
            $vnp_HashSecret = $this->VNP_HASH_SECRET;
            $vnp_Url = $this->VNP_URL;
            $vnp_Returnurl = $this->VNP_RETURN_URL . $request->returnUrl;

            $vnp_TxnRef = rand(1, 10000);
            $vnp_OrderInfo = "Payment for order #" . $vnp_TxnRef;
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->amount * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = $request->bank_name ?? '';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef . '-' . $vnp_OrderInfo,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => $expire

            );
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            return Response::json(true, 'success', ['vnp_Url' => $vnp_Url]);
        } catch (Exception $e) {
            return Response::json(false, $e->getMessage());
        }
    }

    public function checkoutVnpayResult(Request $request)
    {
        $vnp_HashSecret = $this->VNP_HASH_SECRET;
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $request->vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                // Payment successful==========================================
                $validate = Validator::make($request->all(), [
                    'email' => 'required|email|string',
                    'full_name' => 'required|string',
                    'address' => 'required|string',
                    'phone_number' => 'required|string',
                    'quantity' => 'required|integer',
                    'tour_id' => 'required|integer'
                ]);

                if ($validate->fails()) {
                    return Response::json(false, 'Validation failed', $validate->errors());
                }

                $quantity_child = $request->quantity_child ?? 0;
                $quantity_baby = $request->quantity_baby ?? 0;
                $tour = Product::where('id', $request->tour_id)->with(['country', 'province_start', 'province_end', 'process_tour', 'tourguide'])
                    ->first();
                if (!$tour) {
                    return Response::json(false, 'tour_id not found!', null);
                }
                if ($tour->quantity < ($request->quantity + $quantity_child + $quantity_baby)) {
                    return Response::json(false, 'Not enough quantity', null);
                }
                $subtotal = $tour->price * $request->quantity + $tour->price_child * $quantity_child
                    + $tour->price_baby * $quantity_baby;
                $total = $subtotal + $tour->additional_fee;

                $order = Order::create([
                    'email' => $request->email,
                    'full_name' => $request->full_name,
                    'address' => $request->address,
                    'status' => 'success',
                    'phone_number' => $request->phone_number,
                    'payment_status' => 1,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'note' => $request->note ?? "",
                ]);
                $order_detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $tour->id,
                    'quantity' => $request->quantity,
                    'quantity_child' => $quantity_child,
                    'quantity_baby' => $quantity_baby,
                    'additional_fee' => $tour->additional_fee,
                    'price' => $tour->price,
                    'price_child' => $tour->price_child,
                    'price_baby' => $tour->price_baby,
                ]);

                // send mail
                $data['email'] = $request->email;
                $data['title'] = "Xác nhận đặt Tour tại Quin Travel";
                $data['tour'] = $tour;
                $data['subtotal'] = $total;
                $data['total'] = $total;
                $data['order'] = $order;
                $data['order_detail'] = $order_detail;
                Mail::send("mail.api.v1.travel.mail", ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                $order['order_detail'] = $order_detail;
                $order['order_detail']['product'] = $tour;
                return Response::json(true, 'Order successfully created', $order);
                // Payment successful==========================================


            } else {
                // Payment failed
                return Response::json(false, "Payment failed!");
            }
        } else {
            // Invalid signature
            return Response::json(false, "Invalid signature!");
        }
    }
}
