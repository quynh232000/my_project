<?php

namespace App\Http\Middleware;

use App\Traits\ApiRes;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class HmsMiddleware
{
    use ApiRes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @authenticated
         */
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

                // thêm các route ngoại lệ không cần hotel_id
                $routeExcept    = [
                    'api.v1.hms.auth.me',
                    'api.v1.hms.hotel.index'
                ];

                //  lấy hotels id từ login
                $hotel_ids      = auth('hms')->payload()->get('hotel_ids') ?? [];
                $route_name     = $request->route()->getName();
                $hotel_id       = ($request->route('hotel_id') ?? $request->input('hotel_id')) ?? null;
                // dd($route_name, $hotel_id);
                // kiểm tra hotel hoặc route hợp lệ
                if (!in_array($hotel_id, $hotel_ids)) {
                    if (!in_array($route_name ?? false, $routeExcept)) {
                        return $this->error('Bạn không có quyền truy cập.', null, 403);
                    }
                } else {

                    // thêm hotel_id vào user
                    auth('hms')->user()->current_hotel_id    = $hotel_id;

                    //Xóa hotel_id ra khỏi request
                    $request->replace($request->except('hotel_id'));
                }
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
