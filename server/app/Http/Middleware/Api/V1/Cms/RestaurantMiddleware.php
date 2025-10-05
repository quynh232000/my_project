<?php

namespace App\Http\Middleware\Api\V1\Cms;

use Closure;
use App\Traits\ApiRes;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Api\V1\Cms\UserRestaurantRoleModel;

class RestaurantMiddleware
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
            $resraurant_id = $request->restaurant_id ?? null;
            if (!$resraurant_id) {
                return $this->error('Thiếu tham số nhà hàng!');
            }
            $check = UserRestaurantRoleModel::where('user_id', auth('cms')->id())
                ->where('restaurant_id', $resraurant_id)
                ->first();
            if (!$check) {
                return $this->error('Bạn không có quyền truy cập nhà hàng này!', [], 403);
            }
            $reraurant = $check->restaurant;
            auth('cms')->user()->restaurant = $reraurant;

            //Xóa resraurant_id ra khỏi request
            $request->replace($request->except('resraurant_id'));

            return $next($request);
        } catch (\Exception $e) {
            // Lỗi hệ thống
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi!', 'data' => $e->getMessage()], 500);
        }
    }
}
