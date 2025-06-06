<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/post/'], function () {
    require __DIR__ . '/public/api_public_post.php';
});

Route::group(['prefix' => '/home/'], function () {
    require __DIR__ . '/public/api_public_home.php';
});

Route::group(['prefix' => '/product/'], function () {
    require __DIR__ . '/public/api_public_product.php';
});
Route::group(['prefix' => '/user/', 'middleware' => JwtMiddleware::class], function () {
    require __DIR__ . '/public/api_public_user.php';
});
Route::group(['prefix' => '/collection/'], function () {
    require __DIR__ . '/public/api_public_collection.php';
});

