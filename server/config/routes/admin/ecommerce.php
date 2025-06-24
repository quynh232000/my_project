<?php

return  [

    'prefix' => basename(__FILE__, '.php'),
    'label' => 'Ecommerce',
    'middleware' => [],
    'routes' => [
        [
            'type'          => 'resource',
            'uri'           => 'category',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\CategoryController::class,
            'name_prefix'   => 'ecommerce.category',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
         [
            'type'          => 'resource',
            'uri'           => 'payment-method',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\PaymentMethodController::class,
            'name_prefix'   => 'ecommerce.payment-method',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
         [
            'type'          => 'resource',
            'uri'           => 'setting',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\SettingController::class,
            'name_prefix'   => 'ecommerce.setting',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
         [
            'type'          => 'resource',
            'uri'           => 'shop',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\ShopController::class,
            'name_prefix'   => 'ecommerce.shop',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],

    ]

];
