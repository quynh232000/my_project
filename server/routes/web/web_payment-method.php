<?php

use App\Http\Controllers\Admin\PaymentMethodController;
use Illuminate\Support\Facades\Route;
Route::resource('payment-method', PaymentMethodController::class);
Route::get('payment-method/{id}/change-status', [PaymentMethodController::class,'changeStatus'])->name('payment-method.status');
