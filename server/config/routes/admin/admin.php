<?php

return  [

    'prefix' => basename(__FILE__, '.php'),
    // 'middleware' => ['auth'],
    'routes' => [
         [
            'type'          => 'resource',
            'uri'           => 'organization',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\OrganizationController::class,
            'name_prefix'   => 'admin.organization',
            'only'          => ['index', 'edit','store','create','show', 'update','destroy'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing',
                'edit'          => 'Edit Info',
                'update'        => 'Update Info',
                'show'          => 'View Detail',
                'destroy'       => 'Delete',
                'store'         => 'Create',

            ]
        ],
        [
            'type'          => 'resource',
            'uri'           => 'user',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\UserController::class,
            'name_prefix'   => 'admin.user',
            'only'          => ['index', 'edit','create','show', 'update','destroy'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing',
                'edit'          => 'Edit Info',
                'update'        => 'Update Info',
                'show'          => 'View Detail',
                'destroy'       => 'Delete',

            ]
        ],
        [
            'type'          => 'resource',
            'uri'           => 'role',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\RoleController::class,
            'name_prefix'   => 'admin.role',
            'only'          => ['index', 'edit','create','show', 'update','delete'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing quyền',
                'edit'          => 'Chỉnh sửa',
                'update'        => 'Update Info',
                'show'          => 'Edit Info',
                'destroy'        => 'Delete',

            ]
        ],
        [
            'type'          => 'resource',
            'uri'           => 'permission',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'name_prefix'   => 'admin.permission',
            'only'          => ['index', 'edit','create','show', 'update','delete'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing',
                'edit'          => 'Chỉnh sửa',
                'update'        => 'Update Info',
                'destroy'        => 'Delete',
                'show'          => 'Edit Info',
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
