<?php
use App\Http\Controllers\Hotel\PolicySettingController;
use Illuminate\Support\Facades\Route;
 //Hotel policy setting
 Route::resource('hotel/policy-setting', PolicySettingController::class,['as' => 'hotel']);
 Route::get('hotel/policy-setting/status/{status}/{id}', [PolicySettingController::class, 'status'])->name('hotel.policy-setting.status');
 Route::post('hotel/policy-setting/confirm-delete', [PolicySettingController::class, 'confirmDelete'])->name('hotel.policy-setting.confirm-delete');
