<?php
use App\Http\Controllers\Hotel\PostCategoryController;
use App\Http\Controllers\Hotel\PostController;
use App\Http\Controllers\Hotel\CategoryController;
use App\Http\Controllers\Hotel\HotelCategoryController;
use App\Http\Controllers\Hotel\HotelController;
use Illuminate\Support\Facades\Route;
//Hotel
Route::resource('hotel/hotel', HotelController::class,['as' => 'hotel']);
Route::get('hotel/hotel/status/{status}/{id}', [HotelController::class, 'status'])->name('hotel.hotel.status');
Route::post('hotel/hotel/confirm-delete', [HotelController::class, 'confirmDelete'])->name('hotel.hotel.confirm-delete');

//Hotel Category
Route::resource('hotel/hotel-category', HotelCategoryController::class,['as' => 'hotel']);
Route::get('hotel/hotel-category/status/{status}/{id}', [HotelCategoryController::class, 'status'])->name('hotel.hotel-category.status');
Route::post('hotel/hotel-category/confirm-delete', [HotelCategoryController::class, 'confirmDelete'])->name('hotel.hotel-category.confirm-delete');
Route::get('hotel/hotel-category/move/{act}/{id}', [HotelCategoryController::class, 'move'])->name('hotel.hotel-category.move');

//Post
Route::resource('hotel/post', PostController::class,['as' => 'hotel']);
Route::get('hotel/post/status/{status}/{id}', [PostController::class, 'status'])->name('hotel.post.status');
Route::post('hotel/post/confirm-delete', [PostController::class, 'confirmDelete'])->name('hotel.post.confirm-delete');

//Hotel Category
Route::resource('hotel/post-category', PostCategoryController::class,['as' => 'hotel']);
Route::get('hotel/post-category/status/{status}/{id}', [PostCategoryController::class, 'status'])->name('hotel.post-category.status');
Route::post('hotel/post-category/confirm-delete', [PostCategoryController::class, 'confirmDelete'])->name('hotel.post-category.confirm-delete');
Route::get('hotel/post-category/move/{act}/{id}', [PostCategoryController::class, 'move'])->name('hotel.post-category.move');
