<?php

use App\Http\Controllers\Api\Shop\LiveStreamController;
use App\Http\Controllers\Api\Shop\ProductLiveController;
use App\Http\Middleware\IsShopMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class, IsShopMiddleware::class])->group(function () {
    Route::post('/', [LiveStreamController::class, 'create']);
    Route::get('/', [LiveStreamController::class, 'index']);
    Route::get('/current', [LiveStreamController::class, 'current']);

    Route::post('add-product',[ProductLiveController::class,'addProduct']);
});
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/chat', [LiveStreamController::class, 'sendChat']);
    Route::get('/detail/{name}', [LiveStreamController::class, 'detail']);
    Route::get('/history/{name}', [LiveStreamController::class, 'history']);

    Route::get('current-product',[ProductLiveController::class,'currentProduct']);
});
Route::post('/verify', [LiveStreamController::class, 'verify']);
Route::post('/user/add-cart',[ProductLiveController::class,'addCart']);
