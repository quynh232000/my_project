<?php

use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiMiddleware::class, CorsMiddleware::class])->group(function () {
    Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
        require __DIR__ . '/api/v1.php';
    });
});
// require __DIR__ . '/api/v1/hms/_register.php';
// require __DIR__ . '/api/v1/hotel/_register.php';
