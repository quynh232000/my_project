<?php
use App\Http\Controllers\Api\V1\Hms\PaymentInfoController;
use Illuminate\Support\Facades\Route;


Route::name('hms.payment-info.')->group(function () {
    Route::apiResource('payment-info', PaymentInfoController::class)->only(['index','store','update','show']);
});