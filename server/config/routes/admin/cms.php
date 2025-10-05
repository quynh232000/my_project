<?php

use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Cms',
    'middleware'    => [],
    'routes'        => [
        // user_routes
        [
            'type'          => 'resource',
            'uri'           => 'user',
            'controller'    =>  \App\Http\Controllers\Cms\UserController::class,
            'name_prefix'   => $base . '.user',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\UserController::class,
            'uri'           => $base . '/user/status/{status}/{id}',
            'name'          => $base . '.user.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\UserController::class,
            'uri'           => $base . '/user/confirm-delete',
            'name'          => $base . '.user.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // role_routes
        [
            'type'          => 'resource',
            'uri'           => 'role',
            'controller'    =>  \App\Http\Controllers\Cms\RoleController::class,
            'name_prefix'   => $base . '.role',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\RoleController::class,
            'uri'           => $base . '/role/status/{status}/{id}',
            'name'          => $base . '.role.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\RoleController::class,
            'uri'           => $base . '/role/confirm-delete',
            'name'          => $base . '.role.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // permission_routes
        [
            'type'          => 'resource',
            'uri'           => 'permission',
            'controller'    =>  \App\Http\Controllers\Cms\PermissionController::class,
            'name_prefix'   => $base . '.permission',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\PermissionController::class,
            'uri'           => $base . '/permission/status/{status}/{id}',
            'name'          => $base . '.permission.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\PermissionController::class,
            'uri'           => $base . '/permission/confirm-delete',
            'name'          => $base . '.permission.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // restaurant_routes
        [
            'type'          => 'resource',
            'uri'           => 'restaurant',
            'controller'    =>  \App\Http\Controllers\Cms\RestaurantController::class,
            'name_prefix'   => $base . '.restaurant',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\RestaurantController::class,
            'uri'           => $base . '/restaurant/status/{status}/{id}',
            'name'          => $base . '.restaurant.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\RestaurantController::class,
            'uri'           => $base . '/restaurant/confirm-delete',
            'name'          => $base . '.restaurant.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // menu_routes
        [
            'type'          => 'resource',
            'uri'           => 'menu-category',
            'controller'    =>  \App\Http\Controllers\Cms\MenuCategoryController::class,
            'name_prefix'   => $base . '.menu-category',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\MenuCategoryController::class,
            'uri'           => $base . '/menu-category/status/{status}/{id}',
            'name'          => $base . '.menu-category.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\MenuCategoryController::class,
            'uri'           => $base . '/menu-category/confirm-delete',
            'name'          => $base . '.menu-category.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // menu_item_routes
        [
            'type'          => 'resource',
            'uri'           => 'menu-item',
            'controller'    =>  \App\Http\Controllers\Cms\MenuItemController::class,
            'name_prefix'   => $base . '.menu-item',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\MenuItemController::class,
            'uri'           => $base . '/menu-item/status/{status}/{id}',
            'name'          => $base . '.menu-item.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Cms\MenuItemController::class,
            'uri'           => $base . '/menu-item/confirm-delete',
            'name'          => $base . '.menu-item.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
       
    ]

];
