<?php
use App\Http\Controllers\Api\V1\Hms\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::name('hms.room-type.')->group(function () {
    Route::apiResource('room-type', RoomTypeController::class)->only(['index']);
});