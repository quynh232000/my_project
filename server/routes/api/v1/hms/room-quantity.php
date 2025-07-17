<?php
use App\Http\Controllers\Api\V1\Hms\RoomQuantityController;
use Illuminate\Support\Facades\Route;

Route::name('hms.room-quantity.')->group(function () {
    Route::apiResource('room-quantity', RoomQuantityController::class)->only(['store']);
});