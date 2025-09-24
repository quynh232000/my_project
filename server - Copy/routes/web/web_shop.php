<?php
use App\Http\Controllers\Admin\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop.list');
Route::get('/add', [ShopController::class, 'add'])->name('shop.add');
Route::get('/{slug}', [ShopController::class, 'detail'])->name('shop.detail');
Route::post('/update/{shop_id}', [ShopController::class, 'update'])->name('shop.update');