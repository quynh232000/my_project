<?php

namespace App\Http\Middleware\Api\V1\Travel;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            return response()->json(['status' => false, 'message' => 'Token not found!'], 401);
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // return $e;
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => false, 'message' => 'Token is Invalid!'], 401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['status' => false, 'message' => 'Token is Expired!'], 401);
            } else {
                return response()->json(['status' => false, 'message' => 'Authorization Token not found!'], 401);
            }
        }
        return $next($request);
    }
}
