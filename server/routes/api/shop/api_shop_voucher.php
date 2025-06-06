<?php

use App\Http\Controllers\Api\Shop\VoucherController;
use App\Http\Middleware\IsShopMiddleware;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class, IsShopMiddleware::class])->group(function () {
    Route::get('/', [VoucherController::class, 'voucher_index']);
    Route::get('/{id}', [VoucherController::class, 'voucher_get']);
    Route::post('/', [VoucherController::class, 'voucher_create']);
    Route::put('/{id}', [VoucherController::class, 'voucher_clone']);
    Route::post('/{id}', [VoucherController::class, 'voucher_update']);
    Route::delete('/{id}', [VoucherController::class, 'voucher_delete']);
    Route::patch('/{id}', [VoucherController::class, 'voucher_restore']);
});
