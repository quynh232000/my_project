<?php
use App\Http\Controllers\Api\V1\Hms\BookingController;
use Illuminate\Support\Facades\Route;


Route::name('hms.hotel.')->group(function () {
    Route::apiResource('booking', BookingController::class)->only(['index','show']);
});