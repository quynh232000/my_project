<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Hms\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Hms\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\V1\Hms\Auth\VerifyResetCodeRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Api\V1\Hms\CustomerModel;
use App\Models\Customer;
use App\Traits\ApiRes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends HmsController
{
    use ApiRes;
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new Customer();
    }
    public function login(LoginRequest $request)
    {
        try {
            if (!$token = auth('hms')->attempt($request->validated())) {
                return $this->error('Sai thông tin', ['password' => ['Sai mật khẩu!']]);
            }
            return $this->success('Đăng nhập thành công!',  auth('hms')->user(), 200, $this->respondWithToken($token, $request->remember ?? false));
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->input('refresh_token');

            if (!$refreshToken) {
                return $this->error('Lỗi dữ liệu', [
                    'refresh_token' => ['refresh_token là bắt buộc']
                ], 401);
            }

            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);

            // Kiểm tra thời hạn
            if ($decoded['exp'] < time()) {
                return $this->error('Token đã hết hạn', null, 401);
            }

            // Tìm lại user
            $user = Customer::find($decoded['user_id']);
            if (!$user) {
                return $this->error('Không tìm thấy tài khoản', null, 401);
            }

            // Đăng nhập lại user → cấp access_token mới
            $token = auth('hms')->login($user); // login lại user → JWT mới

            $meta = [
                'access_token'  => $token,
                'token_type'    => 'bearer',
                'expires_in'    => config('jwt.ttl') * 60,
                'refresh_token' => $this->createRefreshToken()
            ];

            return $this->success('Làm mới token thành công!', $user, 200, $meta);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    protected function respondWithToken($token, $remember = false)
    {
        $data = [
            'access_token'      => $token,
            'token_type'        => 'bearer',
            'expires_in'        => config('jwt.ttl') * 60
        ];
        if ($remember) {
            $data['refresh_token'] = $this->createRefreshToken();
        }
        return $data;
    }
    protected function createRefreshToken()
    {
        $data = [
            'user_id'   => auth('hms')->user()->id,
            'random'    => rand() . time(),
            'exp'       => time() + config('jwt.refresh_ttl')
        ];
        $refreshToken = JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $result = $this->model->saveItem($this->_params, ['task' => 'forgot-password']);
            if ($result['status']) {
                return $this->success($result['message']);
            }
            return $this->error($result['message']);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $result = $this->model->saveItem($this->_params, ['task' => 'reset-password']);
            if ($result['status']) {
                return $this->success($result['message']);
            }
            return $this->error($result['message']);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->success('Đăng xuất thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi', $e->getMessage());
        }
    }
    public function me()
    {
        try {
            $data = auth('hms')->user();

            return $this->success('Lấy thông tin thành công!', ($data));
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi', $e->getMessage());
        }
    }
    public function verifyResetCode(VerifyResetCodeRequest $request)
    {
        try {
            $result = $this->model->verifyResetCode($this->_params);
            if ($result['status']) {
                return $this->success($result['message']);
            }
            return $this->error($result['message']);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi', $e->getMessage());
        }
    }
    public function register(Request $request)
    {
        try {
            $validator  = Validator::make($request->all(), [
                'full_name'     => 'required|string|max:255',
                'email'         => 'required|string|email|max:255',
                'password'      => 'required|string|min:6'
            ]);
            if ($validator->fails()) {
                return $this->errorInvalidate('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }
            $user  = CustomerModel::where('email', $request->email)->first();
            if ($user) {
                return $this->error('Email đã tồn tại!', ['email' => ['Email đã tồn tại!']]);
            }
            $list_avatars       = [
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
            ];

            $user = Customer::create([
                'full_name' => $request->full_name,
                'username' => explode('@', $request->email)[0],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $list_avatars[rand(0, count($list_avatars) - 1)]
            ]);
            $token = auth('hms')->login($user);
            return $this->success('Đăng kí thành công!',  auth('hms')->user(), 200, $this->respondWithToken($token, true));
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function withgoogle(Request $request)
    {
        try {
            $validator  = Validator::make($request->all(), [
                'id_token'     => 'required|string',
            ]);
            if ($validator->fails()) {
                return $this->errorInvalidate('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }

            $token = $request->id_token;

            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return $this->errorInvalidate('Token không hợp lệ!');
            }
            $payload = $parts[1];
            $decodedPayload = base64_decode($payload);
            if ($decodedPayload === false) {
                return $this->errorInvalidate('Base64 decode failed!');
            }
            $data = json_decode($decodedPayload, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->errorInvalidate('JSON decode failed: ' . json_last_error_msg());
            }

            $user  = Customer::where('email', $data['email'])->first();
            if ($user) {
                $token = auth('hms')->login($user);
                return $this->success('Đăng nhập thành công!',  auth('hms')->user(), 200, $this->respondWithToken($token, true));
            }

            $list_avatars       = [
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
            ];

            $user = Customer::create([
                'full_name' => $data['name'],
                'username' => explode('@', $data['email'])[0],
                'email' => $data['email'],
                'password' => Hash::make('12345678'),
                'image' => $data['picture'] ?? $list_avatars[rand(0, count($list_avatars) - 1)]
            ]);
            $token = auth('hms')->login($user);
            return $this->success('Đăng kí thành công!',  auth('hms')->user(), 200, $this->respondWithToken($token, true));
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
}
