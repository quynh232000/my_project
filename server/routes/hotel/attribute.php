<?php
// use App\Http\Controllers\Hotel\AttributeController;

use App\Http\Controllers\Hotel\AttributeController;
use Illuminate\Support\Facades\Route;

 Route::resource('hotel/attribute', AttributeController::class,['as' => 'hotel']);
 Route::get('hotel/attribute/status/{status}/{id}', [AttributeController::class, 'status'])->name('hotel.attribute.status');
 Route::post('hotel/attribute/confirm-delete', [AttributeController::class, 'confirmDelete'])->name('hotel.attribute.confirm-delete');
 Route::get('hotel/attribute/move/{act}/{id}', [AttributeController::class, 'move'])->name('hotel.attribute.move');
