<?php
use App\Http\Middleware\IsLoginMiddleware;

return  [

    'prefix' => basename(__FILE__, '.php'),
    'label' => 'Quin Admin',
    'middleware' => [IsLoginMiddleware::class],
    'routes' => [
        [
            'type'          => 'resource',
            'uri'           => 'organization',
            'label'         => 'Organazation Managent',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\OrganizationController::class,
            'name_prefix'   => 'admin.organization',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'], // 👈 Chỉ dùng các action này
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
            'only'          => ['index', 'edit', 'create', 'show', 'update', 'destroy', 'store'], // 👈 Chỉ dùng các action này
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
            'only'          => ['index', 'edit', 'create', 'store', 'show', 'update', 'delete', 'destroy'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing quyền',
                'edit'          => 'Chỉnh sửa',
                'update'        => 'Update Info',
                'store'          => 'Create Info',
                'destroy'        => 'Delete',

            ]
        ],
        [
            'type'          => 'resource',
            'uri'           => 'permission',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'name_prefix'   => 'admin.permission',
            'only'          => ['index', 'edit', 'store', 'destroy', 'update'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing',
                'edit'          => 'Chỉnh sửa',
                'store'         => 'Update Info',
                'destroy'       => 'Delete',
            ]
        ],
        [
            'type'          => 'resource',
            'uri'           => 'file-upload',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\FileUploadController::class,
            'name_prefix'   => 'admin.file-upload',
            'only'          => ['index', 'destroy'], // 👈 Chỉ dùng các action này
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
