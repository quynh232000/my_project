<?php

use App\Http\Controllers\Api\V1\Hotel\HotelCategoryController;
use Illuminate\Support\Facades\Route;

Route::apiResource('hotel-category', HotelCategoryController::class)->only(['index','show']);
Route::get('/search/hot-location',[HotelCategoryController::class,'hotLocation'])->name('search.hot-location');
