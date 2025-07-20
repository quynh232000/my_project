<?php

use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
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
        // permission
        [
            'type'          => 'resource',
            'uri'           => 'permission',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'name_prefix'   => 'admin.permission',
            'only'          => ['index', 'edit', 'create', 'store', 'destroy', 'update'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing',
                'edit'          => 'Chỉnh sửa',
                'store'         => 'Update Info',
                'destroy'       => 'Delete',
            ]
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'uri'           => $base . '/permission/status/{status}/{id}',
            'name'          => $base . '.permission.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'uri'           => $base . '/permission/confirm-delete',
            'name'          => $base . '.permission.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'uri'           => $base . '/permission/new',
            'name'          => $base . '.permission.new',
            'methods'       => ['get'],
            'action'        => 'new',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\PermissionController::class,
            'uri'           => $base . '/permission/bulkStore',
            'name'          => $base . '.permission.bulkStore',
            'methods'       => ['post'],
            'action'        => 'bulkStore',
        ],
        // upload file
        [
            'type'          => 'resource',
            'uri'           => 'file-upload',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\FileUploadController::class,
            'name_prefix'   => 'admin.file-upload',
            'only'          => ['index', 'destroy'], // 👈 Chỉ dùng các action này
        ],
        // country_route

        [
            'type'          => 'resource',
            'uri'           => 'country',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\CountryController::class,
            'name_prefix'   => $base . '.country',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\CountryController::class,
            'uri'           => $base . '/country/status/{status}/{id}',
            'name'          => $base . '.country.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\CountryController::class,
            'uri'           => $base . '/country/confirm-delete',
            'name'          => $base . '.country.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\CountryController::class,
            'uri'           => $base . '/country/address',
            'name'          => $base . '.country.address',
            'methods'       => ['get'],
            'action'        => 'address',
        ],
        // province_route
        [
            'type'          => 'resource',
            'uri'           => 'province',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\ProvinceController::class,
            'name_prefix'   => $base . '.province',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\ProvinceController::class,
            'uri'           => $base . '/province/status/{status}/{id}',
            'name'          => $base . '.province.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\ProvinceController::class,
            'uri'           => $base . '/province/confirm-delete',
            'name'          => $base . '.province.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],


        // ward_route
        [
            'type'          => 'resource',
            'uri'           => 'ward',
            'controller'    =>  \App\Http\Controllers\Admin\Admin\WardController::class,
            'name_prefix'   => $base . '.ward',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\WardController::class,
            'uri'           => $base . '/ward/status/{status}/{id}',
            'name'          => $base . '.ward.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Admin\WardController::class,
            'uri'           => $base . '/ward/confirm-delete',
            'name'          => $base . '.ward.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],






    ]

];
