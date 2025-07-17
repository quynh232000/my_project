<?php
use App\Http\Controllers\Api\V1\Hms\PromotionController;
use Illuminate\Support\Facades\Route;


Route::name('hms.promotion.')->group(function () {
    Route::put('promotion/toggle-status/{promotion}', [PromotionController::class, 'toggleStatus'])->name('toggle-status');
    Route::apiResource('promotion', PromotionController::class)->only(['index','store','update','show']);
});