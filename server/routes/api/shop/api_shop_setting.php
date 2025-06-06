<?php

use App\Http\Controllers\Api\Shop\ShopController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index']);

Route::middleware([JwtMiddleware::class])->group(function () {

    /**
     * Review middleware because of the mess in api routes design!!
     */
    Route::post('/', [ShopController::class, 'shop_update_info']);
    Route::delete('/bank/{id}', [ShopController::class, 'shop_delete_bank_account']);
    Route::post('/verify-email-shop', [ShopController::class, 'verify_email_shop']);
    Route::get('/shop_info', [ShopController::class, 'shop_info']);

});
