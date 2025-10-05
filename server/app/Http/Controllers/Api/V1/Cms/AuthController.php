<?php

namespace App\Http\Controllers\Api\V1\Cms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Cms\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Cms\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Cms\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Cms\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\V1\Cms\Auth\VerifyResetCodeRequest;
use App\Models\Api\V1\Cms\UserModel;
use App\Traits\ApiRes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends HmsController
{
    use ApiRes;
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new UserModel();
    }
    public function login(LoginRequest $request)
    {
        try {
            if (!$token = auth('cms')->attempt($request->validated())) {
                return $this->error('Sai thông tin', ['password' => ['Sai mật khẩu!']]);
            }
            $user = auth('cms')->user();

            $user->last_login_at = now();
            $user->save();
            return $this->success('Đăng nhập thành công!',  $user, 200, $this->respondWithToken($token, $request->remember ?? false));
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
            $user = UserModel::find($decoded['user_id']);
            if (!$user) {
                return $this->error('Không tìm thấy tài khoản', null, 401);
            }

            // Đăng nhập lại user → cấp access_token mới
            $token = auth('cms')->login($user); // login lại user → JWT mới

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
            'user_id'   => auth('cms')->user()->id,
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
    /**
     * @authenticated
     */
    public function me()
    {
        try {
            $data = auth('cms')->user();

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
    public function register(RegisterRequest $request)
    {
        try {

            $list_avatars       = [
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
            ];


            $user               = UserModel::create([
                'uuid'              => Str::uuid(),
                'full_name'     => $request->full_name,
                'username'      => explode('@', $request->email)[0],
                'email'         => $request->email,
                'email_verified_at' => now(),
                'password'      => Hash::make($request->password),
                'avatar'         => $list_avatars[rand(0, count($list_avatars) - 1)]
            ]);
            $token = auth('cms')->login($user);
            return $this->success('Đăng kí thành công!',  auth('cms')->user(), 200, $this->respondWithToken($token, true));
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

            $user  = UserModel::where('email', $data['email'])->first();
            if ($user) {
                $token = auth('cms')->login($user);
                return $this->success('Đăng nhập thành công!',  auth('cms')->user(), 200, $this->respondWithToken($token, true));
            }

            $list_avatars       = [
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
            ];

            $user = UserModel::create([
                'full_name' => $data['name'],
                'username' => explode('@', $data['email'])[0],
                'email' => $data['email'],
                'password' => Hash::make('12345678'),
                'image' => $data['picture'] ?? $list_avatars[rand(0, count($list_avatars) - 1)]
            ]);
            $token = auth('cms')->login($user);
            return $this->success('Đăng kí thành công!',  auth('cms')->user(), 200, $this->respondWithToken($token, true));
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
}
