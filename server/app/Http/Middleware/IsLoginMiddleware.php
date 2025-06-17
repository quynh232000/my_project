<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
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
            return redirect()->route('admin.auth.login')->with('error', 'Please login to access this page');
        }

        $route_name     = $request->route()->getName();
        $method         = $request->getMethod();

        if(!auth()->user()->hasPermission($route_name,$method)){
            return redirect()->back()->with('error', 'You dont have permission to access this page');
        }
        return $next($request);
    }
}
