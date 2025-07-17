<?php


use App\Http\Controllers\Hotel\ReviewController;
use Illuminate\Support\Facades\Route;
//Hotel Review
Route::resource('hotel/review', ReviewController::class,['as' => 'hotel']);
Route::get('hotel/review/status/{status}/{id}', [ReviewController::class, 'status'])->name('hotel.review.status');
Route::post('hotel/review/confirm-delete', [ReviewController::class, 'confirmDelete'])->name('hotel.review.confirm-delete');
