<?php

use App\Http\Controllers\Hotel\ServiceController;
use Illuminate\Support\Facades\Route;

    //Hotel Service
    Route::resource('hotel/service', ServiceController::class,['as' => 'hotel']);
    Route::get('hotel/service/status/{status}/{id}', [ServiceController::class, 'status'])->name('hotel.service.status');
    Route::post('hotel/service/confirm-delete', [ServiceController::class, 'confirmDelete'])->name('hotel.service.confirm-delete');
    Route::post('hotel/service/move/{act}/{id}', [ServiceController::class, 'move'])->name('hotel.service.move');
