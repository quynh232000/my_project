<?php
use App\Http\Controllers\Api\V1\Hms\PriceSettingController;
use Illuminate\Support\Facades\Route;

// Route::put('/price-setting/update', [PriceSettingController::class, 'update'])->name('hms.price-setting.update');

Route::name('hms.price-setting.')->group(function () {
    Route::apiResource('price-setting', PriceSettingController::class)->only(['store']);
});