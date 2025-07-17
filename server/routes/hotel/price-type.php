<?php
use App\Http\Controllers\Hotel\DateBasedPriceController;
use App\Http\Controllers\Hotel\PriceTypeController;
use Illuminate\Support\Facades\Route;

//Hotel Price Type
Route::resource('hotel/price-type', 'Hotel\PriceTypeController',['as' => 'hotel']);
Route::get('hotel/price-type/status/{status}/{id}', [PriceTypeController::class, 'status'])->name('hotel.price-type.status');
Route::post('hotel/price-type/confirm-delete', [PriceTypeController::class, 'confirmDelete'])->name('hotel.price-type.confirm-delete');
Route::post('hotel/price-type/get-info', [PriceTypeController::class, 'getInfo'])->name('hotel.price-type.get-info');

//Hotel Date Based Price
Route::resource('hotel/date-based-price', 'Hotel\DateBasedPriceController',['as' => 'hotel']);