<?php

use App\Http\Controllers\Api\Public\ProductController;
use App\Http\Controllers\Api\Public\ProductFuncController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get("/reviews/{product_id}", [ProductFuncController::class, "getProductReviews"]);
Route::get('/search', [ProductController::class, 'searchProduct']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/{product_id}/review', [ProductFuncController::class, 'addProductReview']);
    Route::patch('/reviews/{id}', [ProductFuncController::class, 'hideProductReviewById']);
    Route::post('/reviews/{reviewId}/reply', [ProductFuncController::class, 'replyProductReview']);
    Route::patch('/reviews/{reviewId}/like', [ProductFuncController::class, 'toggleLikeReview']);
    Route::patch('/{reviewId}/love', [ProductFuncController::class, 'toggleLoveProduct']);
});
