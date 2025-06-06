<?php
use App\Http\Controllers\Admin\CoinController;
use App\Http\Controllers\Admin\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/rules', [CoinController::class, 'rules'])->name('coin.rules');
Route::get('/', [CoinController::class, 'index'])->name('coin.list');