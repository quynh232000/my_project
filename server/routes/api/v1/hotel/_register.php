<?php

use Illuminate\Support\Facades\Route;

Route::prefix('hotel')->name('hotel.')->group(function () {

    require_once(__DIR__ .'/partner-register.php');
    require_once(__DIR__ .'/hotel.php');
    require_once(__DIR__ .'/hotel-category.php');
    require_once(__DIR__ .'/chain.php');
    require_once(__DIR__ .'/booking.php');

});
