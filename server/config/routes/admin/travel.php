<?php
$base = basename(__FILE__, '.php');
return  [

    'prefix' => $base,
    'label' => 'Travel',
    'middleware' => [IsLoginMiddleware::class],
    'routes' => [
        // tour
        [
            'type'          => 'resource',
            'uri'           => 'tour',
            'controller'    =>  \App\Http\Controllers\Admin\Travel\TourController::class,
            'name_prefix'   => $base . '.tour',
            'only'          => ['index', 'edit', 'store', 'create','show', 'update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Travel\TourController::class,
            'uri'           => $base . '/tour/status/{status}/{id}',
            'name'          => $base . '.tour.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Travel\TourController::class,
            'uri'           => $base . '/tour/confirm-delete',
            'name'          => $base . '.tour.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // new
        [
            'type'          => 'resource',
            'uri'           => 'news',
            'controller'    =>  \App\Http\Controllers\Admin\Travel\NewsController::class,
            'name_prefix'   => $base . '.news',
            'only'          => ['index', 'edit', 'store', 'create', 'show','update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Travel\NewsController::class,
            'uri'           => $base . '/news/status/{status}/{id}',
            'name'          => $base . '.news.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Travel\NewsController::class,
            'uri'           => $base . '/news/confirm-delete',
            'name'          => $base . '.news.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],

    ]

];
