<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\CartModel;
use App\Models\Api\V1\Ecommerce\CoinTransactionModel;
use App\Models\Api\V1\Ecommerce\PasswordResetTokenModel;
use App\Models\Api\V1\Ecommerce\UserModel;
use App\Models\Api\V1\Ecommerce\UserRoleModel;
use App\Services\FileService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new UserModel();
        parent::__construct($request);
    }
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                            'full_name'     => 'required|string|max:255',
                            'email'         => 'required|string|email|max:255',
                            'password'      => 'required|string|min:6',
                            'code'          => 'required|string|min:6',
                        ]);

            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors(), 400);
            }
            $user = UserModel::where('email', $request->email)->first();
            if ($user) {
                return $this->errorResponse('Email đã tồn tại!', $validator->errors(), 400);
            }
            // check code is correct
            $checkCode      = PasswordResetTokenModel::where(['token' => $request->code, 'email' => $request->email])->first();
            if (!$checkCode) {
                return $this->errorResponse('Mã Code không đúng!', null, 400);
            }
            $list_avatars   = [
                                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
                                'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
                                'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
                                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
                            ];
            $user           = UserModel::create([
                                'uuid'              => Str::uuid(),
                                'full_name'         => $request->full_name,
                                'username'          => explode('@', $request->email)[0],
                                'email'             => $request->email,
                                'password'          => Hash::make($request->password),
                                'email_verified_at' => now(),
                                'avatar'        => $list_avatars[rand(0, count($list_avatars) - 1)]
                            ]);
            UserRoleModel::create([
                                'user_id' => $user->id,
                                'role_id' => 1
                            ]);
            $checkCode->delete();

            $token          = auth('ecommerce')->login($user);
            $user->roles    = ['User'];
            $user->coin_register($user->id);
            $user->total_coin = $user->total_coin();
            $user->shop;
            return $this->successResponse('Đăng ký tài khoản mới thành công!', ['user' => $user, 'meta' => $this->respondWithToken($token)]);
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    public function refreshToken(Request $request)
    {
        $refreshToken       = $request->refreshToken;
        try {
            $decode         = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user           = UserModel::find($decode['user_id']);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            $token          = auth('ecommerce')->login($user);
            $refreshToken   = $this->createRefreshToken();
            return response()->json([
                'access_token'  => $token,
                'token_type'    => 'bearer',
                'expires_in'    => auth('ecommerce')->factory()->getTTL() * 3600,
                'refresh_token' => $this->createRefreshToken(),
            ]);
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    protected function respondWithToken($token)
    {
        return [
                    'access_token'  => $token,
                    'refresh_token' => $this->createRefreshToken(),
                    'token_type'    => 'bearer',
                    'expires_in'    => auth('ecommerce')->factory()->getTTL() * 3600
                ];
    }
    protected function createRefreshToken()
    {
        $data           = [
                            'user_id'   => auth('ecommerce')->user()->id,
                            'random'    => rand() . time(),
                            'exp'       => time() + config('jwt.refresh_ttl')
                        ];
        $refreshToken   = JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }
    public function checkEmail(Request $request)
    {
        try {
            $validate   = Validator::make($request->all(), [
                            'email' => 'required|email'
                        ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng nhập Email!');
            }

            $checkEmail = UserModel::where(['email' => $request->email])->first();
            if ($checkEmail) {
                return $this->errorResponse('Email đã tồn tại!');
            }
            return $this->successResponse('Email hợp lệ.', $request->email);
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    public function verifyEmail(Request $request)
    {
        try {
            $validate       = Validator::make($request->all(), [
                                'email' => 'required|email'
                            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng nhập Email!', $validate->errors());
            }

            $checkToken     = PasswordResetTokenModel::where(['email' => $request->email])->first();

            $randomNumber   = rand(100000, 999999);
            if ($checkToken) {
                $checkToken->token = $randomNumber;
                $checkToken->save();
            } else {
                PasswordResetTokenModel::create([
                    'email' => $request->email,
                    'token' => $randomNumber
                ]);
            }
            // send mail
            $data['email'] = $request->email;
            $data['title'] = '[Quin Ecommerce] - Mã bảo mật tài khoản ';
            $data['code']  = $randomNumber;

            Mail::send("email.verifyemail", ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return $this->successResponse('Đã gửi mã xác nhận qua Email thành công.');
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    public function login(Request $request)
    {
        try {
            $validator          = Validator::make($request->all(), [
                                    'email'         => 'required|string|email|max:255',
                                    'password'      => 'required|string|min:6',
                                ]);
            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }
            $user               = UserModel::where('email', $request->email)->first();
            if (!$user) {
                return $this->errorResponse('Email không tồn tại!');
            }

            // check blocked user
            if ($user->blocked_until && Carbon::now()->lessThan($user->blocked_until)) {
                $remainingTime  = Carbon::parse($user->blocked_until)->diffForHumans();
                return $this->errorResponse("Email của bạn đã bị khóa trong $remainingTime", $remainingTime);
            }

            if (!$token = auth('ecommerce')->attempt($validator->validated())) {
                $user->failed_attempts          += 1;
                if ($user->failed_attempts >= 5) {
                    $user->blocked_until        = Carbon::now()->addDay();
                    $user->failed_attempts      = 0;
                    $user->save();
                    return $this->errorResponse("Email của bạn đã bị khóa trong 1 ngày vì đã đăng nhập sai quá 5 lần.");
                }
                $user->save();
                return $this->errorResponse('Sai mật khẩu!');
            }
            // reset failed attempts on unsuccessful login
            $user->failed_attempts          = 0;
            $user->blocked_until            = null;
            UserModel::where('id', auth('ecommerce')->id())->update([
                            'last_login_at' =>  Carbon::now()
                        ]);
            $user->save();
            $user->coin_login_daily($user->id);
            $user->total_coin   = $user->total_coin();
            $user->shop;
            $user->roles        = $user->roles();

            return $this->successResponse('Đăng nhập thành công!', ['user' => $user, 'meta' => $this->respondWithToken($token)]);
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    public function me()
    {
        try {
            $user               = auth('ecommerce')->user();
            if ($user == null) {
                return $this->errorResponse("Unauthorized", null, 403);
            }
            $coin_last          = CoinTransactionModel::where(['user_id' => auth('ecommerce')->id()])
                                ->orderBy('id', 'desc')
                                ->value('balance_after');
            $user->total_coin   = $coin_last ? $coin_last : 0;
            $user->roles        = $user->roles();
            $user->shop;
            $cart               = CartModel::where('user_id', auth('ecommerce')->id())->with('product.shop')->orderBy('created_at', 'desc')->get();
            return $this->successResponse('Thông tin người dùng.', ['user' => $user, 'cart' => $cart]);
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }

    public function logout()
    {
        auth('ecommerce')->logout();
        return $this->successResponse('Đăng xuất thành công!');
    }
    public function withgoogle(Request $request)
    {
        try {
            $validator      = Validator::make($request->all(), [
                                'id_token' => 'required|string',
                            ]);
            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }
            $token          = ($request->id_token);

            $parts          = explode('.', $token);
            if (count($parts) !== 3) {
                return $this->errorResponse('Token không hợp lệ!');
            }
            $payload        = $parts[1];
            $decodedPayload = base64_decode($payload);
            if ($decodedPayload === false) {
                return $this->errorResponse('Base64 decode failed!');
            }
            $data           = json_decode($decodedPayload, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->errorResponse('JSON decode failed: ' . json_last_error_msg());
            }
            $user           = UserModel::where('email', $data['email'])->first();
            // return $data;
            if ($user) {
                if ($user->blocked_until && Carbon::now()->lessThan($user->blocked_until)) {
                    $remainingTime = Carbon::parse($user->blocked_until)->diffForHumans();
                    return $this->errorResponse("Tài khoản của bạn đã bị khóa trong $remainingTime", $remainingTime);
                }
                $token              = auth('ecommerce')->login($user);
                $user->roles        = ['User'];
                $user->coin_login_daily($user->id);
                $user->total_coin   = $user->total_coin();
                $user->shop;
                $message            = "Đăng nhập thành công!";
                // return $this->successResponse('Đăng nhập thành công!', ['user' => $user, 'meta' => $this->respondWithToken($token)]);
            } else {
                $user               = UserModel::create([
                                        'avatar'            => $data['picture'],
                                        'thumbnail_url'     => $data['picture'],
                                        'uuid'              => Str::uuid(),
                                        'full_name'         => $data['name'],
                                        'username'          => explode('@', $data['email'])[0],
                                        'email'             => $data['email'],
                                        'email_verified_at' => now(),
                                    ]);
                if ($user) {
                    UserRoleModel::create([
                                        'user_id' => $user->id,
                                        'role_id' => 1
                                    ]);
                }
                $user->coin_register($user->id);
                $token              = auth('ecommerce')->login($user);
                $user->roles        = ['User'];
                $message            = 'Đăng kí thành công!';
            }

            $user->total_coin       = $user->total_coin();
            $user->shop;
            UserModel::where('id', auth('ecommerce')->id())->update([
                                        'last_login_at' =>  Carbon::now()
                                    ]);
            return $this->successResponse($message, ['user' => $user, 'meta' => $this->respondWithToken($token)]);
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗii! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    public function forgotpassword(Request $request)
    {
        try {
            $validator      = Validator::make($request->all(), [
                                    'email' => 'required|string',
                                ]);
            if ($validator->fails()) {

                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }
            $user           = UserModel::where(['email' => $request->email])->first();
            if (!$user) {
                return $this->errorResponse('Email không tồn tại trên hệ thống');
            }
            $token          = Str::random(60);
            $user->remember_token = $token;
            $user->save();

            // send mail
            $url            = config('app.common.FRONTEND_URL') . '/forgot-password/' . $token;

            $data['title']  = "[Quin Ecommerce] - Xác nhận thay đổi mật khẩu mới";
            $data['url']    = $url;
            $data['user']   = $user;
            $data['email']  = $user->email;
            Mail::send("email.mailchangepassword", ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return $this->successResponse("Mã xác nhận đã được gửi đến email của bạn. Vui lòng kiểm tra và click vào link để xác nhận thay đổi mật khẩu!");
        } catch (Exception $e) {
            return $this->errorResponse("Đã xảy ra lỗii! Vui lòng thử lại sau.", $e->getMessage(), 500);
        }
    }
    public function changenewpassword(Request $request)
    {
        try {
            $validator          = Validator::make($request->all(), [
                                    'password'  => 'required|string',
                                    'token'     => 'required|string',
                                ]);
            if ($validator->fails()) {
                return $this->errorResponse(false, 'Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }
            $user               = UserModel::where(['remember_token' => $request->token])->first();
            if (!$user) {
                return $this->errorResponse(false, 'Token không tồn tại trên hệ thống');
            }
            $user->password       = Hash::make($request->password);
            $user->remember_token = null;
            $user->save();
            return $this->successResponse("Mật khẩu đã được thay đổi thành công!");
        } catch (Exception $e) {
            return $this->errorResponse("Đã xảy ra lỗi! Vui lòng thử lại sau.", $e->getMessage(), 500);
        }
    }

}
