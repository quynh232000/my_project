<?php 
use App\Http\Controllers\Api\Auth\CoinController;
use App\Http\Controllers\Api\Auth\UsersController;
use App\Http\Controllers\Api\Public\VoucherController;


Route::get('/coin/history', [CoinController::class,'coin_history']);
Route::post('/update-info', [UsersController::class,'update_info']);
Route::post('/change_password', [UsersController::class,'change_password']);
Route::get('/voucher', [VoucherController::class,'my_voucher']);
Route::post('/voucher/save', [VoucherController::class,'save_voucher']);
