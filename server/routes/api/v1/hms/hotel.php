<?php
use App\Http\Controllers\Api\V1\Hms\HotelController;
use Illuminate\Support\Facades\Route;


Route::name('hms.hotel.')->group(function () {
    Route::get('hotel/detail', [HotelController::class, 'detail'])->name('detail');
    Route::apiResource('hotel', HotelController::class)->only(['index','update']);
});