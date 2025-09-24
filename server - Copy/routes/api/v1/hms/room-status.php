<?php
use App\Http\Controllers\Api\V1\Hms\RoomStatusController;
use Illuminate\Support\Facades\Route;

// Route::put('/room-status/update', [RoomStatusController::class, 'update'])->name('hms.room-status.update');

Route::name('hms.room-status.')->group(function () {
    Route::apiResource('room-status', RoomStatusController::class)->only(['store']);
});