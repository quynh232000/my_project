<?php
return [
    'title'     => 'E-Commerce',
    'icon'      => 'ki-outline ki-handcart',
    'name_route' => basename(__FILE__, '.php'),
    'sub'       => [
        [
            'title'      => 'Category',
            'name_route' => basename(__FILE__, '.php').'.category',
            'sub' => [
                ['title' => 'Category Listing', 'route' => 'ecommerce.category.index'],
                ['title' => 'Add Category', 'route' => 'ecommerce.category.create'],
            ],
        ],
         [
            'title' => 'Payment Method',
             'name_route' => basename(__FILE__, '.php').'.payment-method',
            'sub' => [
                ['title' => 'Payment Method Listing', 'route' => 'ecommerce.payment-method.index'],
                ['title' => 'Add Payment Method', 'route' => 'ecommerce.payment-method.create'],
            ],
        ],
         [
            'title' => 'Settings',
             'name_route' => basename(__FILE__, '.php').'.setting',
            'sub' => [
                ['title' => 'Settings Listing', 'route' => 'ecommerce.setting.index'],
                ['title' => 'Add Settings', 'route' => 'ecommerce.setting.create'],
            ],
        ],
        [
            'title' => 'Shops',
             'name_route' => basename(__FILE__, '.php').'.shop',
            'sub' => [
                ['title' => 'Shops Listing', 'route' => 'ecommerce.shop.index'],
                ['title' => 'Add Shops', 'route' => 'ecommerce.shop.create'],
            ],
        ],
        [
            'title' => 'Products',
             'name_route' => basename(__FILE__, '.php').'.product',
            'sub' => [
                ['title' => 'Products Listing', 'route' => 'ecommerce.product.index'],
                ['title' => 'Add Products', 'route' => 'ecommerce.product.create'],
            ],
        ],

    ],
];
