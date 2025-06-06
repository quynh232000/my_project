<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Route;
use Session;
use Str;
use Symfony\Component\HttpFoundation\Response;

class IsLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl         = url()->current();
        Session::put('redirect_url', $currentUrl);

        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('auth.login')->with('error', 'Vui lòng đăng nhập!');
        }
        // Check if user is blocked
        if (auth()->user()->blocked_until && Carbon::now()->lessThan(auth()->user()->blocked_until)) {
            $remainingTime  = Carbon::parse(auth()->user()->blocked_until)->diffForHumans();
            return redirect()->route('auth.login')->with('error', "Email của bạn đã bị khóa trong $remainingTime");
        }

        $roles              = auth()->user()->roles()->toArray() ?? [];

        if (in_array('Supper Admin', $roles)) {
            return $next($request);
        }

        if (!in_array('Admin', $roles)) {
            return redirect()->route('auth.login')->with('error', 'Tài khoản của bạn không có quyền truy cập vô quản trị!');
        }

        // check permissions action get post path delete
        $path = $request->path();
        if($request->isMethod('post') && !in_array('Admin Edit', $roles)){
            return redirect()->back()->with('error', 'Tài khoản của bạn không có quyền thao tác chức năng này!');
        }
        if(($request->isMethod('delete') && !in_array('Admin Delete', $roles)) || (Str::contains($path,'delete'))){
            return redirect()->back()->with('error', 'Tài khoản của bạn không có quyền thao tác chức năng này!');
        }

        return $next($request);

    }
}
