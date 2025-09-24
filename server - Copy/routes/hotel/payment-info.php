<?php

use App\Http\Controllers\Hotel\PaymentInfoController;
use Illuminate\Support\Facades\Route;

Route::resource('hotel/payment-info', PaymentInfoController::class,['as' => 'hotel']);
Route::get('hotel/payment-info/status/{status}/{id}', [PaymentInfoController::class, 'status'])->name('hotel.payment-info.status');
Route::post('hotel/payment-info/confirm-delete', [PaymentInfoController::class, 'confirmDelete'])->name('hotel.payment-info.confirm-delete');
 Route::post('hotel/payment-info/confirm-choose', [PaymentInfoController::class, 'confirmChoose'])->name('hotel.payment-info.confirm-choose');
Route::post('hotel/payment-info/choose', [PaymentInfoController::class, 'choose'])->name('hotel.payment-info.choose');
