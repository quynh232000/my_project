<?php

use App\Http\Middleware\Api\V1\Travel\JwtMiddleware;

$base       = basename(__FILE__, '.php');

return  [
    'prefix'        => $base,
    'label'         => 'Travel',
    'middleware'    => [],
    'routes'        => [
        // user_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/login',
            'name'          => $base . 'auth.login',
            'methods'       => ['post'],
            'action'        => 'login',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/register',
            'name'          => $base . 'auth.register',
            'methods'       => ['post'],
            'action'        => 'register',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/withgoogle',
            'name'          => $base . 'auth.withgoogle',
            'methods'       => ['post'],
            'action'        => 'googleAuthentication',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/forgotpassword',
            'name'          => $base . 'auth.forgotpassword',
            'methods'       => ['post'],
            'action'        => 'forgotpassword',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/changepassword',
            'name'          => $base . 'auth.changepassword',
            'methods'       => ['post'],
            'action'        => 'changepassword',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/get_country',
            'name'          => $base . 'auth.get_city',
            'methods'       => ['get'],
            'action'        => 'get_city',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'get_province',
            'name'          => $base . 'auth.get_province',
            'methods'       => ['get'],
            'action'        => 'get_province',
        ],
        // user
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/me',
            'middleware'    => [JwtMiddleware::class],
            'name'          => $base . 'auth.me',
            'methods'       => ['get'],
            'action'        => 'me',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/logout',
            'middleware'    => [JwtMiddleware::class],
            'name'          => $base . 'auth.logout',
            'methods'       => ['post'],
            'action'        => 'logout',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/refresh',
            'middleware'    => [JwtMiddleware::class],
            'name'          => $base . 'auth.refresh',
            'methods'       => ['post'],
            'action'        => 'refresh',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/change_password',
            'middleware'    => [JwtMiddleware::class],
            'name'          => $base . 'auth.change_password',
            'methods'       => ['post'],
            'action'        => 'change_password',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\AuthController::class,
            'uri'           => 'auth/update_profile',
            'middleware'    => [JwtMiddleware::class],
            'name'          => $base . 'auth.update_profile',
            'methods'       => ['post'],
            'action'        => 'update_profile',
        ],
        // tour_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'tour/update_profile',
            'name'          => $base . 'tour.create',
            'methods'       => ['post'],
            'action'        => 'create',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'tour/like/{tour_id}',
            'name'          => $base . 'tour.like',
            'methods'       => ['get'],
            'action'        => 'like',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'tour/list_tour',
            'name'          => $base . 'tour.list_tour',
            'methods'       => ['get'],
            'action'        => 'list_tour',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'tour/filterproducts',
            'name'          => $base . 'tour.filterproducts',
            'methods'       => ['get'],
            'action'        => 'filterproducts',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'tour/{slug}',
            'name'          => $base . 'tour.getDetail',
            'methods'       => ['get'],
            'action'        => 'getDetail',
        ],

        // order_route

        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'order/history',
            'name'          => $base . 'order.history',
            'methods'       => ['get'],
            'action'        => 'history',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'order/{id}',
            'name'          => $base . 'order.order_detail',
            'methods'       => ['get'],
            'action'        => 'order_detail',
        ],
        // order_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'order/checkout',
            'name'          => $base . 'order.checkout',
            'methods'       => ['post'],
            'action'        => 'checkout',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'order/checkout-vnpay',
            'name'          => $base . 'order.checkout-vnpay',
            'methods'       => ['post'],
            'action'        => 'checkoutVnpay',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\TourController::class,
            'uri'           => 'order/checkout-vnpay-result',
            'name'          => $base . 'order.checkout-vnpay-result',
            'methods'       => ['post'],
            'action'        => 'checkoutVnpayResult',
        ],
        // news_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\NewsController::class,
            'uri'           => 'news/list_news',
            'name'          => $base . 'news.list_news',
            'methods'       => ['get'],
            'action'        => 'list_news',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Travel\NewsController::class,
            'uri'           => 'news/{slug}',
            'name'          => $base . 'news.news_detail',
            'methods'       => ['get'],
            'action'        => 'news_detail',
        ],


    ]

];
