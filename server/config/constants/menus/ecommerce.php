<?php
return [
    'title'     => 'E-Commerce',
    'icon'      => 'ki-outline ki-handcart',
    'name_route' => basename(__FILE__, '.php'),
    'sub'       => [

        // orders
        [
            'title'         => 'Orders',
            'icon'          => 'ki-outline ki-credit-cart text-danger',
            'name_route'    => basename(__FILE__, '.php') . '.order',
            'sub'           => [
                                ['title' => 'Orders', 'route' => 'ecommerce.order.index'],
                                ['title' => 'Orders Shop', 'route' => 'ecommerce.order-shop.index'],
                            ],
        ],
        [
            'title'      => 'Category',
            'name_route' => basename(__FILE__, '.php') . '.category',
            'sub' => [
                ['title' => 'Category Listing', 'route' => 'ecommerce.category.index'],
                ['title' => 'Add Category', 'route' => 'ecommerce.category.create'],
            ],
        ],
        [
            'title' => 'Payment Method',
            'name_route' => basename(__FILE__, '.php') . '.payment-method',
            'sub' => [
                ['title' => 'Payment Method Listing', 'route' => 'ecommerce.payment-method.index'],
                ['title' => 'Add Payment Method', 'route' => 'ecommerce.payment-method.create'],
            ],
        ],
        [
            'title' => 'Settings',
            'name_route' => basename(__FILE__, '.php') . '.setting',
            'sub' => [
                ['title' => 'Settings Listing', 'route' => 'ecommerce.setting.index'],
                ['title' => 'Add Settings', 'route' => 'ecommerce.setting.create'],
            ],
        ],
        [
            'title' => 'Shops',
            'icon' => 'ki-outline ki-briefcase fs-2',
            'name_route' => basename(__FILE__, '.php') . '.shop',
            'sub' => [
                ['title' => 'Shops Listing', 'route' => 'ecommerce.shop.index'],
                ['title' => 'Add Shops', 'route' => 'ecommerce.shop.create'],
            ],
        ],
        [
            'title' => 'Products',
            'name_route' => basename(__FILE__, '.php') . '.product',
            'sub' => [
                ['title' => 'Products Listing', 'route' => 'ecommerce.product.index'],
                ['title' => 'Add Products', 'route' => 'ecommerce.product.create'],
            ],
        ],
        // banner
        [
            'title'         => 'Banners',
            'name_route'    => basename(__FILE__, '.php') . '.banner',
            'sub'           => [
                                ['title' => 'Banner Listing', 'route' => 'ecommerce.banner.index'],
                                // ['title' => 'Add Banner', 'route' => 'ecommerce.banner.create'],
                            ],
        ],
        // Voucher
        [
            'title'         => 'Vouchers',
            'name_route'    => basename(__FILE__, '.php') . '.voucher',
            'sub'           => [
                                ['title' => 'Vouchers Listing', 'route' => 'ecommerce.voucher.index'],
                                // ['title' => 'Add Vouchers', 'route' => 'ecommerce.voucher.create'],
                            ],
        ],
        // Post Type
        [
            'title'         => 'Post Type',
            'name_route'    => basename(__FILE__, '.php') . '.post-type',
            'sub'           => [
                                ['title' => 'Post Type Listing', 'route' => 'ecommerce.post-type.index'],
                                // ['title' => 'Add Post Type', 'route' => 'ecommerce.post-type.create'],
                            ],
        ],
        // category post
        [
            'title'         => 'Post Category',
            'name_route'    => basename(__FILE__, '.php') . '.category-post',
            'sub'           => [
                                ['title' => 'Post Category Listing', 'route' => 'ecommerce.category-post.index'],
                                // ['title' => 'Add Post Category', 'route' => 'ecommerce.category-post.create'],
                            ],
        ],
        // Post
        [
            'title'         => 'Posts',
            'name_route'    => basename(__FILE__, '.php') . '.post',
            'sub'           => [
                                ['title' => 'Posts Listing', 'route' => 'ecommerce.post.index',],
                                // ['title' => 'Add Posts', 'route' => 'ecommerce.post.create'],
                            ],
        ],
         // livestream
        [
            'title'         => 'Livestream',
            'name_route'    => basename(__FILE__, '.php') . '.livestream',
            'sub'           => [
                                ['title' => 'Livestream Listing', 'route' => 'ecommerce.livestream.index']
                            ],
        ],
          // coin
        [
            'title'         => 'Coins',
            'name_route'    => basename(__FILE__, '.php') . '.coin',
            'sub'           => [
                                ['title' => 'Coins Rule Listing', 'route' => 'ecommerce.coin-rule.index'],
                                ['title' => 'Coins Listing', 'route' => 'ecommerce.coin-transaction.index'],
                            ],
        ],
           // bank
        [
            'title'         => 'Banks',
            'name_route'    => basename(__FILE__, '.php') . '.bank',
            'sub'           => [
                                ['title' => 'Banks Listing', 'route' => 'ecommerce.bank.index',],
                                ['title' => 'Add Banks', 'route' => 'ecommerce.bank.create'],
                            ],
        ],

    ],
];
