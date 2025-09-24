<?php
use App\Http\Controllers\Hotel\PromotionController;
use Illuminate\Support\Facades\Route;
 //Hotel promotion
 Route::resource('hotel/promotion', 'Hotel\PromotionController',['as' => 'hotel']);
 Route::get('hotel/promotion/status/{status}/{id}', [PromotionController::class, 'status'])->name('hotel.promotion.status');
 Route::post('hotel/promotion/confirm-delete', [PromotionController::class, 'confirmDelete'])->name('hotel.promotion.confirm-delete');
 Route::post('hotel/promotion/get-info', [PromotionController::class, 'getInfo'])->name('hotel.promotion.get-info');