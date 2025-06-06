<?php

use App\Http\Controllers\Api\Public\BannerController;
use App\Http\Controllers\Api\Public\CategoryController;
use App\Http\Controllers\Api\Public\ContactController;
use App\Http\Controllers\Api\Public\LiveController;
use App\Http\Controllers\Api\Public\ProductController;
use App\Http\Controllers\Api\Public\VoucherController;
use App\Http\Controllers\Api\Public\SearchController;
use App\Http\Controllers\Api\Shop\ShopController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/category', [CategoryController::class, 'categoryHome']);
Route::group(['prefix' => 'search'], function () {
    // Route::get('/{search_query}', [SearchController::class, 'fuzzy_query']);
    // Route::get('/suggesters/{search_query}', [SearchController::class, 'suggesters']);
});
Route::middleware([JwtMiddleware::class])->group(function () { });
Route::get('/category-all', [CategoryController::class, 'categoryAll']);
Route::get('/voucher', [VoucherController::class, 'get_voucher']);
Route::get('/brand', [CategoryController::class, 'get_brand']);
Route::get('/attribute_name', [CategoryController::class, 'attribute_name']);

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'get_products']);
    Route::get('/get_product_slug/{slug}', [ProductController::class, 'product_by_slug']);

});
// shop
Route::prefix('shop')->middleware([JwtMiddleware::class])->group(function () {
    Route::post('/follow_shop/{shop_id}', [ProductController::class, 'follow_shop']);

});
Route::get('shop/info/{slug}', [ProductController::class, 'get_shop_page']);
Route::get('banner', [BannerController::class, 'get_home_banner']);
Route::prefix('contact')->group(function () {
    Route::post('/', [ContactController::class, 'create']);

});
Route::prefix('live')->group(function () {
    Route::get('/', [LiveController::class, 'index']);

});
Route::prefix('shop')->group(function () {
    Route::get('/list', [ShopController::class, 'shop_list_home']);
});
