<?php

use App\Http\Controllers\Api\Shop\OrderController;
use App\Http\Middleware\IsShopMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class, IsShopMiddleware::class])->group(function () {

    Route::get('/', [OrderController::class, 'order_index']);
    Route::get('/{id}', [OrderController::class, 'order_get']);
    Route::put('/', [OrderController::class, 'order_update_status']);

    Route::get('/{id}/detail', [OrderController::class, 'order_detail_index']);
    Route::get('/{id}/detail/{id_detail}', [OrderController::class, 'order_detail_get']);
});
