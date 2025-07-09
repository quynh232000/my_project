<?php

use App\Http\Controllers\Hotel\BankController;
use Illuminate\Support\Facades\Route;
//Hotel accommodation
Route::resource('hotel/bank', BankController::class,['as' => 'hotel']);
Route::get('hotel/bank/status/{status}/{id}', [BankController::class, 'status'])->name('hotel.bank.status');
Route::post('hotel/bank/confirm-delete', [BankController::class, 'confirmDelete'])->name('hotel.bank.confirm-delete');
