<?php
use App\Http\Controllers\Hotel\ChainController;
use Illuminate\Support\Facades\Route;
 //Hotel policy setting
 Route::resource('hotel/chain', ChainController::class,['as' => 'hotel']);
 Route::get('hotel/chain/status/{status}/{id}', [ChainController::class, 'status'])->name('hotel.chain.status');
 Route::post('hotel/chain/confirm-delete', [ChainController::class, 'confirmDelete'])->name('hotel.chain.confirm-delete');
