<?php

namespace App\Http\Middleware\Api\V1\Ecommerce;

use Closure;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JwtMiddleware extends BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            //code...
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['status' => false, 'message' => 'Token not found!'], 403);
            }
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof AuthenticationException) {
                    return response()->json(['error' => 'Token is required or invalid'], 401);
                }

                if ($e instanceof JWTException) {
                    return response()->json(['error' => 'Token is invalid or expired'], 401);
                }
                // return $e;
                if ($e instanceof TokenInvalidException) {
                    return response()->json(['status' => false, 'message' => 'Token is Invalid!'], 401);
                } else if ($e instanceof TokenExpiredException) {
                    return response()->json(['status' => false, 'message' => 'Token is Expired!'], 401);
                } else {
                    return response()->json(['status' => false, 'message' => 'Authorization!'], 401);
                }
            }
            return $next($request);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi!','data'=>$e->getMessage()], 500);
        }
    }
}
