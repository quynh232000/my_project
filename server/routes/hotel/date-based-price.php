<?php

use App\Http\Controllers\Hotel\DateBasedPriceController;
use App\Http\Controllers\Hotel\PriceRuleController;
use Illuminate\Support\Facades\Route;
//Date Based Price
Route::get('hotel/hotel/date-based-price/{hotel}', [DateBasedPriceController::class, 'dateBasedPrice'])->name('hotel.hotel.date-based-price');

//Price Rule
Route::resource('hotel/price-rule', 'Hotel\PriceRuleController',['as' => 'hotel']);