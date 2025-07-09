<?php
use App\Http\Controllers\Api\V1\Hms\RoomController;
use Illuminate\Support\Facades\Route;


Route::name('hms.room.')->group(function () {
    Route::get('room/list', [RoomController::class, 'list'])->name('list');
    Route::put('room/toggle-status', [RoomController::class, 'toggleStatus'])->name('toggle-status');
    Route::apiResource('room', RoomController::class)->only(['index','store','show','update']);
});