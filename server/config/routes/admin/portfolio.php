<?php
use App\Http\Middleware\IsLoginMiddleware;

return  [

    'prefix' => basename(__FILE__, '.php'),
    'label' => 'Portfolio',
    'middleware' => [IsLoginMiddleware::class],
    'routes' => [
        [
            'type'          => 'resource',
            'uri'           => 'category',
            'controller'    =>  \App\Http\Controllers\Admin\Portfolio\CategoryController::class,
            'name_prefix'   => 'portfolio.category',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'], // 👈 Chỉ dùng các action này
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
            'uri'           => 'icon',
            'controller'    =>  \App\Http\Controllers\Admin\Portfolio\IconController::class,
            'name_prefix'   => 'portfolio.icon',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'], // 👈 Chỉ dùng các action này
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
            'uri'           => 'image',
            'controller'    =>  \App\Http\Controllers\Admin\Portfolio\ImageController::class,
            'name_prefix'   => 'portfolio.image',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'], // 👈 Chỉ dùng các action này
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
            'uri'           => 'data-info',
            'controller'    =>  \App\Http\Controllers\Admin\Portfolio\DataInfoController::class,
            'name_prefix'   => 'portfolio.data-info',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'], // 👈 Chỉ dùng các action này
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
            'uri'           => 'project',
            'controller'    =>  \App\Http\Controllers\Admin\Portfolio\ProjectController::class,
            'name_prefix'   => 'portfolio.project',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'], // 👈 Chỉ dùng các action này
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
            'uri'           => 'blog',
            'controller'    =>  \App\Http\Controllers\Admin\Portfolio\BlogController::class,
            'name_prefix'   => 'portfolio.blog',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'], // 👈 Chỉ dùng các action này
            'labels'        => [
                'index'         => 'Listing',
                'edit'          => 'Edit Info',
                'update'        => 'Update Info',
                'show'          => 'View Detail',
                'destroy'       => 'Delete',
                'store'         => 'Create',

            ]
        ],
    ]

];
