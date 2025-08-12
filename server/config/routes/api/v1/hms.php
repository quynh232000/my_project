<?php

use App\Http\Middleware\HmsMiddleware;
use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'HMS',
    'middleware'    => [],
    'routes'        => [
        // auth_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/login',
            'name'          =>  $base . '.auth.login',
            'methods'       => ['post'],
            'action'        => 'login',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/register',
            'name'          =>  $base . '.auth.register',
            'methods'       => ['post'],
            'action'        => 'register',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/withgoogle',
            'name'          =>  $base . '.auth.withgoogle',
            'methods'       => ['post'],
            'action'        => 'withgoogle',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/refresh',
            'name'          =>  $base . '.auth.refresh',
            'methods'       => ['post'],
            'action'        => 'refresh',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/forgot-password',
            'name'          =>  $base . '.auth.forgot-password',
            'methods'       => ['post'],
            'action'        => 'forgotPassword',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/reset-password',
            'name'          =>  $base . '.auth.reset-password',
            'methods'       => ['post'],
            'action'        => 'resetPassword',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/logout',
            'name'          =>  $base . '.auth.logout',
            'methods'       => ['post'],
            'action'        => 'logout',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'uri'           =>  'auth/verify-reset-code',
            'name'          =>  $base . '.auth.verify-reset-code',
            'methods'       => ['post'],
            'action'        => 'verifyResetCode',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AuthController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'auth/me',
            'name'          =>  $base . '.auth.me',
            'methods'       => ['get'],
            'action'        => 'me',
        ],
        // album_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AlbumController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'album/list',
            'name'          =>  $base . '.album.list',
            'methods'       => ['get'],
            'action'        => 'list',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AlbumController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'album/edit',
            'name'          =>  $base . '.album.edit',
            'methods'       => ['post'],
            'action'        => 'edit',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\AlbumController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'album/delete',
            'name'          =>  $base . '.album.delete',
            'methods'       => ['delete'],
            'action'        => 'delete',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\AlbumController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'album',
            'name_prefix'   => $base . '.album',
            'only'          => ['index',  'store'],
        ],
        // attribute_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\AttributeController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'attribute',
            'name_prefix'   => $base . '.attribute',
            'only'          => ['index'],
        ],
        // bank-brand_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\BankBranchController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'bank-branch',
            'name_prefix'   => $base . '.bank-branch',
            'only'          => ['index'],
        ],
        // bank-brand_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\BankController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'bank',
            'name_prefix'   => $base . '.bank',
            'only'          => ['index'],
        ],
        // booking_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\BookingController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'booking',
            'name_prefix'   => $base . '.booking',
            'only'          => ['index', 'show'],
        ],
        // chain_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\ChainController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'chain',
            'name_prefix'   => $base . '.chain',
            'only'          => ['index'],
        ],
        // chain_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\CustomerController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'customer',
            'name_prefix'   => $base . '.customer',
            'only'          => ['index'],
        ],
        // hotel-service_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\HotelServiceController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'hotel-service',
            'name_prefix'   => $base . '.hotel-service',
            'only'          => ['index', 'store'],
        ],
        // hotel_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\HotelController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'hotel/detail',
            'name'          =>  $base . '.hotel.detail',
            'methods'       => ['get'],
            'action'        => 'detail',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\HotelController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'hotel',
            'name_prefix'   => $base . '.hotel',
            'only'          => ['index', 'update'],
        ],
        // language_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\LanguageController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'language',
            'name_prefix'   => $base . '.language',
            'only'          => ['index'],
        ],
        // payment-info_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PaymentInfoController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'payment-info',
            'name_prefix'   => $base . '.payment-info',
            'only'          => ['index', 'store', 'update', 'show'],
        ],
        // policy-cancellation_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\PolicyCancellationController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'policy-cancellation/toggle-status/{policy_cancellation}',
            'name'          =>  $base . '.policy-cancellation.toggleStatus',
            'methods'       => ['put'],
            'action'        => 'toggleStatus',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PolicyCancellationController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'policy-cancellation',
            'name_prefix'   => $base . '.policy-cancellation',
            'only'          => ['index', 'show', 'store', 'destroy'],
        ],
        // policy-children_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PolicyChildrenController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'policy-children',
            'name_prefix'   => $base . '.policy-children',
            'only'          => ['index', 'store',  'destroy'],
        ],
        // policy-general_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PolicyGeneralController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'policy-general',
            'name_prefix'   => $base . '.policy-general',
            'only'          => ['index', 'store'],
        ],
        // policy-other_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PolicyOtherController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'policy-other',
            'name_prefix'   => $base . '.policy-other',
            'only'          => ['index', 'store',  'show'],
        ],
        // policy-setting_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PolicySettingController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'policy-setting',
            'name_prefix'   => $base . '.policy-setting',
            'only'          => ['index'],
        ],
        // price-setting_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PriceSettingController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'price-setting',
            'name_prefix'   => $base . '.price-setting',
            'only'          => ['store'],
        ],
        // price-type_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\PriceTypeController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'price-type/toggle-status/{price_type}',
            'name'          =>  $base . '.price-type.toggleStatus',
            'methods'       => ['put'],
            'action'        => 'toggleStatus',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PriceTypeController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'price-type',
            'name_prefix'   => $base . '.price-type',
            'only'          => ['index', 'store', 'show', 'destroy'],
        ],
        // promotion_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\PromotionController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'promotion/toggle-status/{price_type}',
            'name'          =>  $base . '.promotion.toggleStatus',
            'methods'       => ['put'],
            'action'        => 'toggleStatus',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\PromotionController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'promotion',
            'name_prefix'   => $base . '.promotion',
            'only'          => ['index', 'store', 'show', 'update'],
        ],
        // room-name_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\RoomNameController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'room-name',
            'name_prefix'   => $base . '.room-name',
            'only'          => ['index'],
        ],
        // room-price_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\RoomPriceController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'room-price/history',
            'name'          =>  $base . '.room-price.history',
            'methods'       => ['get'],
            'action'        => 'history',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\RoomPriceController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'room-price',
            'name_prefix'   => $base . '.room-price',
            'only'          => ['store'],
        ],
        // room-quantity_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\RoomQuantityController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'room-quantity',
            'name_prefix'   => $base . '.room-quantity',
            'only'          => ['store'],
        ],
        // room-status_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\RoomStatusController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'room-status',
            'name_prefix'   => $base . '.room-status',
            'only'          => ['store'],
        ],
        // room-type_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\RoomTypeController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'room-type',
            'name_prefix'   => $base . '.room-type',
            'only'          => ['index'],
        ],
        // room_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\RoomController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'room/list',
            'name'          =>  $base . '.room.list',
            'methods'       => ['get'],
            'action'        => 'list',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hms\RoomController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           =>  'room/toggle-status',
            'name'          =>  $base . '.room.toggle-status',
            'methods'       => ['put'],
            'action'        => 'toggleStatus',
        ],
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\RoomController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'room',
            'name_prefix'   => $base . '.room',
            'only'          => ['index', 'store', 'show', 'update'],
        ],
        // service_route
        [
            'type'          => 'resource',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hms\ServiceController::class,
            'middleware'    => [HmsMiddleware::class],
            'uri'           => 'service',
            'name_prefix'   => $base . '.service',
            'only'          => ['index'],
        ],

    ]
];
