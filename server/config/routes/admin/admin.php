<?php

return  [

    'prefix' => basename(__FILE__, '.php'),
    // 'middleware' => ['auth'],
    'routes' => [
        [
            'type'          => 'resource',
            'uri'           => 'user',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\UserController::class,
            'name_prefix'   => 'admin.user',
            'only'          => ['index', 'edit','create', 'update'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Xem danh sách người dùng',
                'edit'          => 'Hiển thị form sửa người dùng',
                'update'        => 'Cập nhật người dùng',
            ]
        ],
        // [
        //     'controller'    =>  \App\Http\Controllers\Admin\Admin\GeneralController::class,
        //     'uri'           => 'user',
        //     'name'          => 'admin.admin.user',
        //     'methods'       => ['get','post'],
        //     'action'        => 'login',
        //     'labels'        => 'Login'
        // ],



    ]

];
