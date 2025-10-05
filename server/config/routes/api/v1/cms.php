<?php

use App\Http\Middleware\Api\V1\Cms\CmsMiddleware;
use App\Http\Middleware\Api\V1\Cms\RestaurantMiddleware;


$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Cms',
    'middleware'    => [],
    'routes'        => [
        // auth_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
            'uri'           =>  'auth/login',
            'name'          =>  $base . '.auth.login',
            'methods'       => ['post'],
            'action'        => 'login',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
            'uri'           =>  'auth/register',
            'name'          =>  $base . '.auth.register',
            'methods'       => ['post'],
            'action'        => 'register',
        ],
        // [
        //     'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
        //     'uri'           =>  'auth/withgoogle',
        //     'name'          =>  $base . '.auth.withgoogle',
        //     'methods'       => ['post'],
        //     'action'        => 'withgoogle',
        // ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
            'uri'           =>  'auth/refresh',
            'name'          =>  $base . '.auth.refresh',
            'methods'       => ['post'],
            'action'        => 'refresh',
        ],
        // [
        //     'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
        //     'uri'           =>  'auth/forgot-password',
        //     'name'          =>  $base . '.auth.forgot-password',
        //     'methods'       => ['post'],
        //     'action'        => 'forgotPassword',
        // ],
        // [
        //     'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
        //     'uri'           =>  'auth/reset-password',
        //     'name'          =>  $base . '.auth.reset-password',
        //     'methods'       => ['post'],
        //     'action'        => 'resetPassword',
        // ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
            'uri'           =>  'auth/logout',
            'name'          =>  $base . '.auth.logout',
            'methods'       => ['post'],
            'action'        => 'logout',
        ],
        // [
        //     'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
        //     'uri'           =>  'auth/verify-reset-code',
        //     'name'          =>  $base . '.auth.verify-reset-code',
        //     'methods'       => ['post'],
        //     'action'        => 'verifyResetCode',
        // ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\AuthController::class,
            'middleware'    => [CmsMiddleware::class],
            'uri'           =>  'auth/me',
            'name'          =>  $base . '.auth.me',
            'methods'       => ['get'],
            'action'        => 'me',
        ],

        // role
        [
            'type'          => 'resource',
            'uri'           => 'role',
            'middleware'    => [CmsMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\RoleController::class,
            'name_prefix'   => $base . '.role',
            'only'          => ['index', 'show', 'store', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\RoleController::class,
            'middleware'    => [CmsMiddleware::class],
            'uri'           =>  'role/toggle-status',
            'name'          =>  $base . '.role.toggle-status',
            'methods'       => ['post'],
            'action'        => 'toggleStatus',
        ],
        // permission
        [
            'type'          => 'resource',
            'uri'           => 'permission',
            'middleware'    => [CmsMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\PermissionController::class,
            'name_prefix'   => $base . '.permission',
            'only'          => ['index',  'store'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\PermissionController::class,
            'middleware'    => [CmsMiddleware::class],
            'uri'           =>  'permission/new',
            'name'          =>  $base . '.permission.new',
            'methods'       => ['get'],
            'action'        => 'new',
        ],
        // user
        [
            'type'          => 'resource',
            'uri'           => 'user',
            'middleware'    => [CmsMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\UserController::class,
            'name_prefix'   => $base . '.user',
            'only'          => ['index',  'store','update','show'],
        ],
        // route_plan
        [
            'type'          => 'resource',
            'uri'           => 'plan',
            'middleware'    => [CmsMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\PlanController::class,
            'name_prefix'   => $base . '.plan',
            'only'          => ['index',  'store','update','show', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\PlanController::class,
            'middleware'    => [CmsMiddleware::class],
            'uri'           =>  'plan/toggle-status',
            'name'          =>  $base . '.plan.toggle-status',
            'methods'       => ['post'],
            'action'        => 'toggleStatus',
        ],
        // route_restaurant
         [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\RestaurantController::class,
            'middleware'    => [CmsMiddleware::class],
            'uri'           =>  'restaurant/list',
            'name'          =>  $base . '.restaurant.list',
            'methods'       => ['get'],
            'action'        => 'list',
        ],
        [
            'type'          => 'resource',
            'uri'           => 'restaurant',
            'middleware'    => [CmsMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\RestaurantController::class,
            'name_prefix'   => $base . '.restaurant',
            'only'          => ['index',  'store','update','show', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\RestaurantController::class,
            'middleware'    => [CmsMiddleware::class,RestaurantMiddleware::class],
            'uri'           =>  'restaurant/toggle-status',
            'name'          =>  $base . '.restaurant.toggle-status',
            'methods'       => ['post'],
            'action'        => 'toggleStatus',
        ],

        // restaurant category
        [
            'type'          => 'resource',
            'uri'           => 'menu-category',
            'middleware'    => [CmsMiddleware::class,RestaurantMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\MenuCategoryController::class,
            'name_prefix'   => $base . '.menu-category',
            'only'          => ['index',  'store','update','show', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\MenuCategoryController::class,
            'middleware'    => [CmsMiddleware::class,RestaurantMiddleware::class],
            'uri'           =>  'menu-category/toggle-status',
            'name'          =>  $base . '.menu-category.toggle-status',
            'methods'       => ['post'],
            'action'        => 'toggleStatus',

        ],
        // restaurant menu item
      
        [
            'type'          => 'resource',
            'uri'           => 'menu-item',
            'middleware'    => [CmsMiddleware::class,RestaurantMiddleware::class],
            'controller'    =>  \App\Http\Controllers\Api\V1\Cms\MenuItemController::class,
            'name_prefix'   => $base . '.menu-item',
            'only'          => ['index',  'store','update','show', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Cms\MenuItemController::class,
            'middleware'    => [CmsMiddleware::class,RestaurantMiddleware::class],
            'uri'           =>  'menu-item/toggle-status',
            'name'          =>  $base . '.menu-item.toggle-status',
            'methods'       => ['post'],
            'action'        => 'toggleStatus',
        ],


    ]
];
