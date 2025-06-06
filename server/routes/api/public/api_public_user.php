<?php

use App\Http\Controllers\Api\Public\AddressController;
use App\Http\Controllers\Api\Public\CartController;
use App\Http\Controllers\Api\Public\ChatController;
use App\Http\Controllers\Api\Public\CoinController;
use App\Http\Controllers\Api\Public\NotificationController;
use App\Http\Controllers\Api\Public\OrderController;
use App\Http\Controllers\Api\Public\VoucherController;
use Illuminate\Support\Facades\Route;

Route::prefix('address')->group(function () {
    Route::get('/', [AddressController::class, 'get_address']);
    Route::post('/', [AddressController::class, 'create_address']);
    Route::get('/address-default', [AddressController::class, 'get_default_address']);
    Route::get('/{address_id}', [AddressController::class, 'get_address_by_id']);
    Route::patch('/{address_id}', [AddressController::class, 'update_address']);
    Route::delete('/{address_id}', [AddressController::class, 'delete_address']);
    Route::patch('/set-default/{address_id}', [AddressController::class, 'set_default_address']);
});
Route::prefix('cart')->group(function () {
    Route::post('/add_to_cart', [CartController::class, 'add_to_cart']);
    Route::post('/asyn_cart', [CartController::class, 'asyn_cart']);
    Route::post('/update_cart', [CartController::class, 'update_cart']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/get_fee_ship', [CartController::class, 'get_fee_ship']);
});
Route::prefix('order')->group(function () {
    Route::post('/order_payment_information', [OrderController::class, 'order_payment_information']);
    Route::post('/check_status_payment', [OrderController::class, 'check_status_payment']);
    Route::post('/vnpay_info_payment', [OrderController::class, 'checkoutVnpay']);
    Route::post('/momo_info_payment', [OrderController::class, 'momo_info_payment']);
    Route::post('/verify_payment', [OrderController::class, 'verify_payment']);
    Route::get('/history', [OrderController::class, 'my_order_history']);
    Route::get('/history/{id}', [OrderController::class, 'my_order_history_detail']);
    Route::patch('/history/{id}/cancel', [OrderController::class, 'cancel_order']);
});
Route::prefix('coin')->group(function () {
    Route::get('/', [CoinController::class, 'my_coin']);
});
Route::prefix('notify')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::get('/{id}', [NotificationController::class, 'show']);
    Route::post('/read-all', [NotificationController::class, 'readAll']);
});
Route::prefix('chat')->group(function () {
    Route::get('/list',[ChatController::class,'list']);
    Route::get('/by_id/{cons_id}',[ChatController::class,'by_id']);
    Route::get('/message/{id}',[ChatController::class,'getMessage']);
    Route::post('/send_message',[ChatController::class,'sendMessage']);
    // Route::get('/delete_message/{message_id}',[ChatController::class,'deleteMessage']);
    Route::get('/get_conversations',[ChatController::class,'getConversations']);
    Route::get('/message-not-read',[ChatController::class,'countMessageNotRead']);
    Route::delete('/{id}',[ChatController::class,'deleteMessage']);

});
