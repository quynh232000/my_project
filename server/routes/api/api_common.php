<?php

use App\Http\Controllers\Api\Common\CommonController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => JwtMiddleware::class], function () {
    Route::post('file/upload', [CommonController::class, 'upload_file']);
    Route::post('file/uploads', [CommonController::class, 'upload_files']);
    Route::prefix('address')->group(function () {
        Route::get('provinces', [CommonController::class, 'get_provinces']);
        Route::get('districts/{province_id}', [CommonController::class, 'get_district']);
        Route::get('wards/{district_id}', [CommonController::class, 'get_ward']);
    });
    Route::get('banks', [CommonController::class, 'get_banks']);
    Route::get('payment_methods', [CommonController::class, 'payment_methods']);
    Route::get('get_settings', [CommonController::class, 'get_settings']);
});


