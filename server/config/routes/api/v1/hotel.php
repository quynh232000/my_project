<?php

use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Hotel',
    'middleware'    => [],
    'routes'        => [
        // settting_routes
        // hotel-category_route
        [
            'type'          => 'resource',
            'uri'           => 'hotel-category',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hotel\HotelCategoryController::class,
            'name_prefix'   => $base . '.hotel-category',
            'only'          => ['index', 'show'],
        ],
        // hotel-hotel_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\HotelController::class,
            'uri'           =>  'hotel/search',
            'name'          =>  $base . '.hotel.search',
            'methods'       => ['get'],
            'action'        => 'search',
        ],
        [
            'type'          => 'resource',
            'uri'           => 'hotel',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hotel\HotelController::class,
            'name_prefix'   => $base . '.hotel',
            'only'          => ['index', 'show'],
        ],



        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PartnerRegisterController::class,
            'uri'           =>  'partner-register/create',
            'name'          =>  $base . '.partner-register.store',
            'methods'       => ['post'],
            'action'        => 'store',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\HotelController::class,
            'uri'           =>  'hotel/filter',
            'name'          =>  $base . '.hotel.filter',
            'methods'       => ['post'],
            'action'        => 'filter',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\HotelController::class,
            'uri'           =>  'hotel/clone',
            'name'          =>  $base . '.hotel.clone',
            'methods'       => ['post'],
            'action'        => 'clone',
        ],

        // post-categorry_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PostCategoryController::class,
            'uri'           =>  'post-category/list',
            'name'          =>  '.post-category.list',
            'methods'       => ['post'],
            'action'        => 'list',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PostCategoryController::class,
            'uri'           =>  'post-category/detail',
            'name'          =>  '.post-category.detail',
            'methods'       => ['post'],
            'action'        => 'detail',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PostCategoryController::class,
            'uri'           =>  'post-category/meta',
            'name'          =>  '.post-category.meta',
            'methods'       => ['post'],
            'action'        => 'meta',
        ],
        // post_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PostController::class,
            'uri'           =>  'post/list',
            'name'          =>  '.post.list',
            'methods'       => ['post'],
            'action'        => 'list',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PostController::class,
            'uri'           =>  'post/detail',
            'name'          =>  '.post.detail',
            'methods'       => ['post'],
            'action'        => 'detail',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PostController::class,
            'uri'           =>  'post/meta',
            'name'          =>  '.post.meta',
            'methods'       => ['post'],
            'action'        => 'meta',
        ],
        // chain_route
        [
            'type'          => 'resource',
            'uri'           => 'chain',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hotel\ChainController::class,
            'name_prefix'   => $base . '.chain',
            'only'          => ['index'],
        ],
        // banner_route
        [
            'type'          => 'resource',
            'uri'           => 'banner',
            'controller'    =>  \App\Http\Controllers\Api\V1\Hotel\BannerController::class,
            'name_prefix'   => $base . '.banner',
            'only'          => ['index'],
        ],
        // bookingroute
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\BookingController::class,
            'uri'           =>  'booking/info',
            'name'          =>  '.booking.info',
            'methods'       => ['post'],
            'action'        => 'info',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\BookingController::class,
            'uri'           =>  'booking/order',
            'name'          =>  '.booking.order',
            'methods'       => ['post'],
            'action'        => 'order',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\BookingController::class,
            'uri'           =>  'booking/order-verify',
            'name'          =>  '.booking.order-verify',
            'methods'       => ['post'],
            'action'        => 'order-verify',
        ],

    ]
];

// Route::apiResource('chain', ChainController::class)->only(['index']);
// Route::apiResource('hotel-category', HotelCategoryController::class)->only(['index','show']);
// Route::get('/search/hot-location',[HotelCategoryController::class,'hotLocation'])->name('search.hot-location');

// Route::get('/hotel/search',[HotelController::class,'search'])->name('hotel.search');
// Route::get('/hotel/filter', [HotelController::class, 'filter'])->name('hotel.filter');
// Route::apiResource('hotel', HotelController::class)->only(['index','show']);
