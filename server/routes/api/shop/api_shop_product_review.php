<?php

use App\Http\Controllers\Api\Shop\ProductReviewController;
use App\Http\Middleware\IsShopMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class, IsShopMiddleware::class])->group(function () {

    Route::get('/', [ProductReviewController::class, 'review_index']);
    Route::get('/{product_id}', [ProductReviewController::class, 'review_get']);

    Route::get('/{product_id}/detail/{id}', [ProductReviewController::class, 'review_detail_get']);
    // Route::get('/{id}/detail', [ProductReviewController::class, 'review_detail_index']);
    // Route::get('/{id}/detail/{id_detail}', [ProductReviewController::class, 'review_detail_get']);
});
