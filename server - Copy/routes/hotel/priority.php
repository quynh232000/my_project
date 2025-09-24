<?php
use App\Http\Controllers\Hotel\PriorityController;
use Illuminate\Support\Facades\Route;

 //Hotel priority
 Route::resource('hotel/priority', 'Hotel\PriorityController',['as' => 'hotel']);
 Route::get('hotel/priority/status/{status}/{id}', [PriorityController::class, 'status'])->name('hotel.priority.status');
 Route::post('hotel/priority/confirm-delete', [PriorityController::class, 'confirmDelete'])->name('hotel.priority.confirm-delete');