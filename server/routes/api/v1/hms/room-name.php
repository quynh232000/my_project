<?php
use App\Http\Controllers\Api\V1\Hms\RoomNameController;
use Illuminate\Support\Facades\Route;

Route::name('hms.room-name.')->group(function () {
    Route::apiResource('room-name', RoomNameController::class)->only(['index']);
});