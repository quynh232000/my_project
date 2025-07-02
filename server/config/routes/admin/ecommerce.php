<?php
use App\Http\Middleware\IsLoginMiddleware;
$base = basename(__FILE__, '.php');
return  [

    'prefix' => basename(__FILE__, '.php'),
    'label' => 'Ecommerce',
    'middleware' => [IsLoginMiddleware::class],
    'routes' => [
        // categoy
        [
            'type'          => 'resource',
            'uri'           => 'category',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\CategoryController::class,
            'name_prefix'   => $base . '.category',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CategoryController::class,
            'uri'           => $base . '/category/status/{status}/{id}',
            'name'          => $base . '.category.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CategoryController::class,
            'uri'           => $base . '/category/confirm-delete',
            'name'          => $base . '.category.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // payment-method
        [
            'type'          => 'resource',
            'uri'           => 'payment-method',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\PaymentMethodController::class,
            'name_prefix'   => $base . '.payment-method',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
          [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\PaymentMethodController::class,
            'uri'           => $base . '/payment-method/status/{status}/{id}',
            'name'          => $base . '.payment-method.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\PaymentMethodController::class,
            'uri'           => $base . '/payment-method/confirm-delete',
            'name'          => $base . '.payment-method.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // sestting
        [
            'type'          => 'resource',
            'uri'           => 'setting',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\SettingController::class,
            'name_prefix'   => $base . '.setting',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
           [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\SettingController::class,
            'uri'           => $base . '/setting/status/{status}/{id}',
            'name'          => $base . '.setting.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\SettingController::class,
            'uri'           => $base . '/setting/confirm-delete',
            'name'          => $base . '.setting.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // shop
        [
            'type'          => 'resource',
            'uri'           => 'shop',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\ShopController::class,
            'name_prefix'   => $base . '.shop',
            'only'          => ['index', 'edit', 'store', 'show','create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\ShopController::class,
            'uri'           => $base . '/shop/status/{status}/{id}',
            'name'          => $base . '.shop.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\ShopController::class,
            'uri'           => $base . '/shop/confirm-delete',
            'name'          => $base . '.shop.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        //    product
        [
            'type'          => 'resource',
            'uri'           => 'product',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\ProductController::class,
            'name_prefix'   => $base . '.product',
            'only'          => ['index', 'edit', 'store','show', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\ProductController::class,
            'uri'           => $base . '/product/status/{status}/{id}',
            'name'          => $base . '.product.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\ProductController::class,
            'uri'           => $base . '/product/confirm-delete',
            'name'          => $base . '.product.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // banner
         [
            'type'          => 'resource',
            'uri'           => 'banner',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\BannerController::class,
            'name_prefix'   => $base . '.banner',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\BannerController::class,
            'uri'           => $base . '/banner/status/{status}/{id}',
            'name'          => $base . '.banner.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\BannerController::class,
            'uri'           => $base . '/banner/confirm-delete',
            'name'          => $base . '.banner.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // voucher
         [
            'type'          => 'resource',
            'uri'           => 'voucher',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\VoucherController::class,
            'name_prefix'   => $base . '.voucher',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\VoucherController::class,
            'uri'           => $base . '/voucher/status/{status}/{id}',
            'name'          => $base . '.voucher.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\VoucherController::class,
            'uri'           => $base . '/voucher/confirm-delete',
            'name'          => $base . '.voucher.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // Post Type
         [
            'type'          => 'resource',
            'uri'           => 'post-type',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\PostTypeController::class,
            'name_prefix'   => $base . '.post-type',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\PostTypeController::class,
            'uri'           => $base . '/post-type/status/{status}/{id}',
            'name'          => $base . '.post-type.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\PostTypeController::class,
            'uri'           => $base . '/post-type/confirm-delete',
            'name'          => $base . '.post-type.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // category post
         [
            'type'          => 'resource',
            'uri'           => 'category-post',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\CategoryPostController::class,
            'name_prefix'   => $base . '.category-post',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CategoryPostController::class,
            'uri'           => $base . '/category-post/status/{status}/{id}',
            'name'          => $base . '.category-post.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CategoryPostController::class,
            'uri'           => $base . '/category-post/confirm-delete',
            'name'          => $base . '.category-post.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // post
         [
            'type'          => 'resource',
            'uri'           => 'post',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\PostController::class,
            'name_prefix'   => $base . '.post',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\PostController::class,
            'uri'           => $base . '/post/status/{status}/{id}',
            'name'          => $base . '.post.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\PostController::class,
            'uri'           => $base . '/post/confirm-delete',
            'name'          => $base . '.post.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // order
         [
            'type'          => 'resource',
            'uri'           => 'order',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\OrderController::class,
            'name_prefix'   => $base . '.order',
            'only'          => ['index', 'show','edit'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\OrderController::class,
            'uri'           => $base . '/order/confirm-delete',
            'name'          => $base . '.order.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // order shop
         [
            'type'          => 'resource',
            'uri'           => 'order-shop',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\OrderShopController::class,
            'name_prefix'   => $base . '.order-shop',
            'only'          => ['index', 'show','edit','show'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\OrderShopController::class,
            'uri'           => $base . '/order-shop/confirm-delete',
            'name'          => $base . '.order-shop.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // livestream
         [
            'type'          => 'resource',
            'uri'           => 'livestream',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\LivestreamController::class,
            'name_prefix'   => $base . '.livestream',
            'only'          => ['index', 'show','edit','destroy','create'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\LivestreamController::class,
            'uri'           => $base . '/livestream/confirm-delete',
            'name'          => $base . '.livestream.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // coin rule
         [
            'type'          => 'resource',
            'uri'           => 'coin-rule',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\CoinRuleController::class,
            'name_prefix'   => $base . '.coin-rule',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CoinRuleController::class,
            'uri'           => $base . '/coin-rule/status/{status}/{id}',
            'name'          => $base . '.coin-rule.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CoinRuleController::class,
            'uri'           => $base . '/coin-rule/confirm-delete',
            'name'          => $base . '.coin-rule.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
         // coin rule
         [
            'type'          => 'resource',
            'uri'           => 'coin-transaction',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\CoinTransactionController::class,
            'name_prefix'   => $base . '.coin-transaction',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CoinTransactionController::class,
            'uri'           => $base . '/coin-transaction/status/{status}/{id}',
            'name'          => $base . '.coin-transaction.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\CoinTransactionController::class,
            'uri'           => $base . '/coin-transaction/confirm-delete',
            'name'          => $base . '.coin-transaction.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
         // bank
         [
            'type'          => 'resource',
            'uri'           => 'bank',
            'controller'    =>  \App\Http\Controllers\Admin\Ecommerce\BankController::class,
            'name_prefix'   => $base . '.bank',
            'only'          => ['index', 'edit', 'store', 'create', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\BankController::class,
            'uri'           => $base . '/bank/status/{status}/{id}',
            'name'          => $base . '.bank.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Ecommerce\BankController::class,
            'uri'           => $base . '/bank/confirm-delete',
            'name'          => $base . '.bank.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],


    ]

];
