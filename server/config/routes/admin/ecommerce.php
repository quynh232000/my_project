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
          [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\ShopController::class,
            'uri'           => 'ecommerce/shop/status/{status}/{id}',
            'name'          => 'ecommerce.shop.status',
            'methods'       => ['get'],
            'action'        => 'status',
          ],
         [
            'type'          => 'resource',
            'uri'           => 'product',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\ProductController::class,
            'name_prefix'   => 'ecommerce.product',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\ProductController::class,
            'uri'           => 'ecommerce/product/status/{status}/{id}',
            'name'          => 'ecommerce.product.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ]
    ]

];
