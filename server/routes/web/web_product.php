<?php
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [ProductController::class, 'index'])->name('product.list');
Route::get('/add', [ProductController::class, 'add'])->name('product.add');
Route::get('/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::post('/add', [ProductController::class, '_add'])->name('product._add');
Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
Route::get('/update_status/{product_id}', [ProductController::class, 'update_status'])->name('product.update_status');
Route::get('/restore/{product_id}', [ProductController::class, 'restore_product'])->name('product.restore');
Route::get('/update_status_all', [ProductController::class, 'update_status_all'])->name('product.update_status_all');
Route::post('/update_publish/{product_id}', [ProductController::class, 'update_publish'])->name('product.update_publish');