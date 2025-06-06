<?php

use App\Http\Controllers\Api\Shop\DashboardController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
    Route::group(['prefix' => '/voucher/'], function () {
        require __DIR__ . '/shop/api_shop_voucher.php';
    });

    Route::group(['prefix' => '/setting/'], function () {
        require __DIR__ . '/shop/api_shop_setting.php';
    });

    Route::group(['prefix' => '/banner/'], function () {
        require __DIR__ . '/shop/api_shop_banner.php';
    });

    Route::group(['prefix' => '/product/'], function () {
        require __DIR__ . '/shop/api_shop_product.php';
    });

    Route::group(['prefix' => '/order/'], function () {
        require __DIR__ . '/shop/api_shop_order.php';
    });

    Route::group(['prefix' => '/review/'], function () {
        require __DIR__ . '/shop/api_shop_product_review.php';
    });
    Route::group(['prefix' => '/live/'], function () {
        require __DIR__ . '/shop/api_shop_livestream.php';
    });
    Route::prefix('dashboard')->middleware([JwtMiddleware::class])->group(function(){
        Route::get('/',[DashboardController::class,'dashboard']);
    });
