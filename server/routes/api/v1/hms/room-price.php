<?php
use App\Http\Controllers\Api\V1\Hms\RoomPriceController;
use Illuminate\Support\Facades\Route;

Route::name('hms.room-price.')->group(function () {
    Route::get('room-price/history', [RoomPriceController::class, 'history'])->name('history');
    Route::apiResource('room-price', RoomPriceController::class)->only(['store']);
});