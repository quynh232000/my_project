<?php

use App\Http\Controllers\Api\V1\Hotel\BookingController;
use Illuminate\Support\Facades\Route;
Route::post('/booking/info', [BookingController::class, 'info'])->name('booking.info');
Route::post('/booking/order', [BookingController::class, 'order'])->name('booking.order');
Route::post('/booking/order-verify', [BookingController::class, 'order_verify'])->name('booking.order-verify');