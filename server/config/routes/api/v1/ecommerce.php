<?php
$base   = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Travel',
    'middleware'    => [],
    'routes'        => [
        // category
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\CategoryController::class,
            'uri'           => 'category',
            'name'          => $base.'category.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],
        // banner
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\BannerController::class,
            'uri'           => 'banner',
            'name'          => $base.'banner.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],
        // voucher
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\VoucherController::class,
            'uri'           => 'voucher',
            'name'          => $base.'voucher.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],
         // product
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\ProductController::class,
            'uri'           => 'product',
            'name'          => $base.'product.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\ProductController::class,
            'uri'           => 'product/filter',
            'name'          => $base.'product.filter',
            'methods'       => ['get'],
            'action'        => 'filter',
        ],
         [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\ProductController::class,
            'uri'           => 'product/{slug}',
            'name'          => $base.'product.show',
            'methods'       => ['get'],
            'action'        => 'show',
        ],
         // post
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\PostController::class,
            'uri'           => 'post',
            'name'          => $base.'post.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],
         // live
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\LivestreamController::class,
            'uri'           => 'livestream',
            'name'          => $base.'livestream.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],
          // shop
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Ecommerce\ShopController::class,
            'uri'           => 'shop',
            'name'          => $base.'shop.index',
            'methods'       => ['get'],
            'action'        => 'index',
        ],


    ]

];
