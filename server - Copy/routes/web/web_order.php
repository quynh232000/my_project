<?php
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrderController::class, 'index'])->name('order.index');
Route::get('/user', [OrderController::class, 'user'])->name('order.user');
Route::get('/shop/{order_code}', [OrderController::class, 'index'])->name('order.shop_id');
Route::get('/detail/{order_shop_id}', [OrderController::class, 'order_detail'])->name('order.shop_detail');
Route::get('/delively', [OrderController::class, 'delevely'])->name('order.delivery');
Route::get('/delivery/{id}/{status}', [OrderController::class, 'delivery_status'])->name('order.delivery.status');
