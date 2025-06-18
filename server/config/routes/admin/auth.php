<?php

return  [

    'prefix' => basename(__FILE__, '.php'),
    // 'middleware' => ['is_login'],
    'routes' => [
        // [
        //     'type'          => 'resource',
        //     'uri'           => 'users',
        //     'controller'    =>     \App\Http\Controllers\Admin\Auth\UserController::class,
        //     'name_prefix'   => 'users',
        //     'only'          => ['index', 'edit', 'update'], // 👈 Chỉ dùng các action này
        //     'labels'        => [
        //         'index'         => 'Xem danh sách người dùng',
        //         'edit'          => 'Hiển thị form sửa người dùng',
        //         'update'        => 'Cập nhật người dùng',
        //     ]
        // ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'login',
            'name'          => 'admin.auth.login',
            'methods'       => ['get'],
            'action'        => 'login',
            'labels'        => 'Login View'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'login',
            'name'          => 'admin.auth.login',
            'methods'       => ['post'],
            'action'        => '_login',
            'labels'        => 'Login Store'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'register',
            'name'          => 'admin.auth.register',
            'methods'       => ['get'],
            'action'        => 'register',
            'labels'        => 'Register Vew'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'register',
            'name'          => 'admin.auth.register',
            'methods'       => ['post'],
            'action'        => '_register',
            'labels'        => 'Register store'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'reset-password',
            'name'          => 'admin.auth.reset-password',
            'methods'       => ['get', 'post'],
            'action'        => 'reset_password',
            'labels'        => 'Reset Password View'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'new-password',
            'name'          => 'admin.auth.new-password',
            'methods'       => ['get', 'post'],
            'action'        => 'new_password',
            'labels'        => 'New Password Store'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'two-factor',
            'name'          => 'admin.auth.two-factor',
            'methods'       => ['get', 'post'],
            'action'        => 'two_factor',
            'labels'        => 'Two Factor View'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => 'logout',
            'name'          => 'admin.auth.logout',
            'methods'       => ['get'],
            'action'        => 'logout'
        ],
        [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => '{provider}/redirect',
            'name'          => 'admin.auth.redirect',
            'methods'       => ['get'],
            'action'        => 'redirect'
        ],
         [
            'controller'    =>  \App\Http\Controllers\Admin\Auth\UserController::class,
            'uri'           => '{provider}/callback',
            'name'          => 'admin.auth.callback',
            'methods'       => ['get'],
            'action'        => 'callback'
        ],


    ]

];
