<?php
use Illuminate\Support\Facades\Route;


require_once(__DIR__ .'/auth.php');

Route::middleware(['hms','throttle:300,1'])
->prefix('hms')
->group(function () {
    require_once(__DIR__ .'/customer.php');
    require_once(__DIR__ .'/hotel.php');
    require_once(__DIR__ .'/room.php');
    require_once(__DIR__ .'/attribute.php');
    require_once(__DIR__ .'/language.php');
    require_once(__DIR__ .'/service.php');
    require_once(__DIR__ .'/hotel-service.php');
    require_once(__DIR__ .'/payment-info.php');
    require_once(__DIR__ .'/bank.php');
    require_once(__DIR__ .'/album.php');
    require_once(__DIR__ .'/policy-setting.php');
    require_once(__DIR__ .'/policy-general.php');
    require_once(__DIR__ .'/policy-children.php');
    require_once(__DIR__ .'/policy-cancellation.php');
    require_once(__DIR__ .'/policy-other.php');
    require_once(__DIR__ .'/bank-branch.php');
    require_once(__DIR__ .'/price-type.php');
    require_once(__DIR__ .'/room-status.php');
    require_once(__DIR__ .'/room-quantity.php');
    require_once(__DIR__ .'/room-price.php');
    require_once(__DIR__ .'/price-setting.php');
    require_once(__DIR__ .'/promotion.php');
    require_once(__DIR__ .'/room-type.php');
    require_once(__DIR__ .'/room-name.php');
    require_once(__DIR__ .'/chain.php');
    require_once(__DIR__ .'/booking.php');
});
