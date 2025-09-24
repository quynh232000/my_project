<?php
use App\Http\Controllers\Api\V1\Hms\CustomerController;
use Illuminate\Support\Facades\Route;

Route::name('hms.customer.')->group(function () {
    Route::apiResource('customer', CustomerController::class)->only(['index','show','store']);
});