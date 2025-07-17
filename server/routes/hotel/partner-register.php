<?php

use App\Http\Controllers\Hotel\PartnerRegisterController;
use Illuminate\Support\Facades\Route;
 //Hotel partner register
 Route::resource('hotel/partner-register', PartnerRegisterController::class,['as' => 'hotel']);
 Route::get('hotel/partner-register/status/{status}/{id}', [PartnerRegisterController::class, 'status'])->name('hotel.partner-register.status');
 Route::post('hotel/partner-register/confirm-delete', [PartnerRegisterController::class, 'confirmDelete'])->name('hotel.partner-register.confirm-delete');
 Route::post('hotel/partner-register/confirm-choose', [PartnerRegisterController::class, 'confirmChoose'])->name('hotel.partner-register.confirm-choose');
 Route::post('hotel/partner-register/choose', [PartnerRegisterController::class, 'choose'])->name('hotel.partner-register.choose');
