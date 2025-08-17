<?php

namespace App\Http\Middleware\Api\V1\Hotel;

use App\Traits\ApiRes;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class HotelLoginMiddelware
{
    use ApiRes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                // Token không được gửi trong yêu cầu
                return $this->error('Không tìm thấy token!', null, 403);
            }

            // gọi refresh_token
            if ($request->refresh_token ?? false) {
                return $this->error('token_expired', null, 401);
            }

            try {
                JWTAuth::parseToken()->authenticate();
            } catch (\Exception $e) {

                $mapMess    = [
                    \Tymon\JWTAuth\Exceptions\TokenExpiredException::class    => 'token_expired',
                    \Tymon\JWTAuth\Exceptions\TokenInvalidException::class    => 'Token không hợp lệ!',
                    \Tymon\JWTAuth\Exceptions\JWTException::class             => 'Token bị thiếu hoặc không thể giải mã!',
                    \Illuminate\Auth\AuthenticationException::class           => 'Yêu cầu cần xác thực! Token không hợp lệ hoặc thiếu.',
                ];

                $message    = $mapMess[get_class($e)] ?? 'Lỗi không xác định: ' . $e->getMessage();

                return $this->error($message, null, 401);
            }

            return $next($request);
        } catch (\Exception $e) {
            // Lỗi hệ thống
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi!', 'data' => $e->getMessage()], 500);
        }
    }
}
