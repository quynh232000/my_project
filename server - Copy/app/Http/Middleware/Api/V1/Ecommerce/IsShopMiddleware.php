<?php

namespace App\Http\Middleware\Api\V1\Ecommerce;

use Closure;
use Error;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsShopMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user_roles = auth('ecommerce')->user()->roles()->toArray();

            if (in_array('Seller', $user_roles)) {
                return $next($request);
            }
            return response()->json(['status' => false, 'message' => 'Vui lòng cập nhật thông tin để trở thành nhà bán hàng.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi!', 'data' => $e->getMessage()], 500);
        }
    }
}
