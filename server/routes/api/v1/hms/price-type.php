<?php
use App\Http\Controllers\Api\V1\Hms\PriceTypeController;
use Illuminate\Support\Facades\Route;


Route::name('hms.price-type.')->group(function () {
    Route::put('price-type/toggle-status/{price_type}', [PriceTypeController::class, 'toggleStatus'])->name('toggle-status');
    Route::apiResource('price-type', PriceTypeController::class)->only(['index','store','show','destroy']);
});