<?php

use App\Http\Controllers\Api\Shop\BannerController;
use App\Http\Middleware\IsShopMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class, IsShopMiddleware::class])->group(function () {
    Route::get('/', [BannerController::class, 'banner_index']);
    Route::get('/{id}', [BannerController::class, 'banner_get']);
    Route::post('/', [BannerController::class, 'banner_create']);
    Route::post('/{id}', [BannerController::class, 'banner_update']);
    Route::delete('/{id}', [BannerController::class, 'banner_delete']);
    Route::patch('/{id}/', [BannerController::class, 'banner_restore']);
});
