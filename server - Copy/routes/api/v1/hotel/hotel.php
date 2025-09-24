<?php

use App\Http\Controllers\Api\V1\Hotel\HotelController;
use Illuminate\Support\Facades\Route;

Route::get('/hotel/search',[HotelController::class,'search'])->name('hotel.search');
Route::get('/hotel/filter', [HotelController::class, 'filter'])->name('hotel.filter');
Route::apiResource('hotel', HotelController::class)->only(['index','show']);
