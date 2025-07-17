<?php
use App\Http\Controllers\Api\V1\Hms\HotelServiceController;
use Illuminate\Support\Facades\Route;


Route::name('hms.hotel-service.')->group(function () {
    Route::apiResource('hotel-service', HotelServiceController::class)->only(['index','store']);
});