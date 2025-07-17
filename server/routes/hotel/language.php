<?php

use App\Http\Controllers\Hotel\LanguageController;
use Illuminate\Support\Facades\Route;
//Hotel accommodation
Route::resource('hotel/language', 'Hotel\LanguageController',['as' => 'hotel']);
Route::get('hotel/language/status/{status}/{id}', [LanguageController::class, 'status'])->name('hotel.language.status');
Route::post('hotel/language/confirm-delete', [LanguageController::class, 'confirmDelete'])->name('hotel.language.confirm-delete');