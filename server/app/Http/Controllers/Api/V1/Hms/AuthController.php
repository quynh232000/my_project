<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Hms\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Hms\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\V1\Hms\Auth\VerifyResetCodeRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Traits\ApiRes;
use Illuminate\Http\Request;
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
}
