<?php

use App\Http\Controllers\Api\ProductImportController;
use App\Http\Controllers\Api\Shop\ProductController;
use App\Http\Middleware\IsShopMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class, IsShopMiddleware::class])->group(function () {

    Route::post('/import', [ProductImportController::class, 'import']);
    Route::get('/', [ProductController::class, 'product_index']);
    Route::get('/{id}', [ProductController::class, 'product_get']);

    Route::post('/', [ProductController::class, 'product_create']);
    Route::post('/{id}', [ProductController::class, 'product_update']);
    Route::post('/{id}/info', [ProductController::class, 'product_update_info']);
    Route::post('/{id}/cate', [ProductController::class, 'product_update_cate']);
    Route::post('/{id}/warehouse', [ProductController::class, 'product_update_warehouse']);
    Route::post('/{id}/stock', [ProductController::class, 'product_update_stock']);
    Route::post('/{id}/shipping', [ProductController::class, 'product_update_shipping']);
    Route::post('/{id}/media', [ProductController::class, 'product_update_media']);
    Route::post('/{id}/clone', [ProductController::class, 'product_clone']);
    Route::post('/{id}/attribute/{attribute_id}', [ProductController::class, 'product_update_attribute_by_id']);

    Route::patch('/{id}', [ProductController::class, 'product_restore']);
    Route::delete('/{id}', [ProductController::class, 'product_delete']);

    /** FE demands */
    Route::get('/{id}/visibility', [ProductController::class, 'product_update_visibility']);

    Route::delete('/{id}/attribute/{attribute_id}', [ProductController::class, 'product_delete_attribute_by_id']);
    Route::delete('/{id}/image/{image_id}', [ProductController::class, 'product_delete_image_by_id']);



});
