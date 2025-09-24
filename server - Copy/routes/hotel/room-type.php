<?php
use App\Http\Controllers\Hotel\RoomController;
use App\Http\Controllers\Hotel\RoomTypeController;
use Illuminate\Support\Facades\Route;

//Hotel Room Type
Route::resource('hotel/room-type', RoomTypeController::class,['as' => 'hotel']);
Route::get('hotel/room-type/status/{status}/{id}', [RoomTypeController::class, 'status'])->name('hotel.room-type.status');
Route::post('hotel/room-type/confirm-delete', [RoomTypeController::class, 'confirmDelete'])->name('hotel.room-type.confirm-delete');

