<?php

use App\Http\Controllers\Hotel\CustomerController;
use Illuminate\Support\Facades\Route;
 //Hotel partner register
 Route::resource('hotel/customer', CustomerController::class,['as' => 'hotel']);
 Route::get('hotel/customer/status/{status}/{id}', [CustomerController::class, 'status'])->name('hotel.customer.status');
 Route::post('hotel/customer/confirm-delete', [CustomerController::class, 'confirmDelete'])->name('hotel.customer.confirm-delete');
