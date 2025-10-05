<?php

namespace App\Http\Middleware\Api\V1\Cms;

use App\Traits\ApiRes;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CmsMiddleware
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
                $user = JWTAuth::parseToken()->authenticate();
                if (!$user) {
                    return $this->error('User không tồn tại!', null, 401);
                }

                // Gắn vào guard cms để middleware sau dùng được
                auth()->shouldUse('cms'); // chọn guard
                auth()->setUser($user);   // set user cho request hiện tại
                // return $this->success('ok',$user);
                // check permission
                // $route_name     = $request->route()->getName();
                // $method         = $request->getMethod();
                // return $this->success('ok',[$method,$route_name]);
                // if (!auth()->user()->hasPermission($route_name, $method)) {
                //     return $this->error('Bạn không có quyền truy cập yêu cầu này!',[],403);
                // }
                

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
