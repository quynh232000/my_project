<?php
return [
    'title'     => 'E-Commerce',
    'icon'      => 'ki-outline ki-handcart',
    'sub'       => [
        [
            'title' => 'Category',
            'sub' => [
                ['title' => 'Category Listing', 'route' => 'ecommerce.category.index'],
                ['title' => 'Add Category', 'route' => 'ecommerce.category.create'],
            ],
        ],
         [
            'title' => 'Payment Method',
            'sub' => [
                ['title' => 'Payment Method Listing', 'route' => 'ecommerce.payment-method.index'],
                ['title' => 'Add Payment Method', 'route' => 'ecommerce.payment-method.create'],
            ],
        ],
         [
            'title' => 'Settings',
            'sub' => [
                ['title' => 'Settings Listing', 'route' => 'ecommerce.setting.index'],
                ['title' => 'Add Settings', 'route' => 'ecommerce.setting.create'],
            ],
        ],
          [
            'title' => 'Shops',
            'sub' => [
                ['title' => 'Shops Listing', 'route' => 'ecommerce.shop.index'],
                ['title' => 'Add Shops', 'route' => 'ecommerce.shop.create'],
            ],
        ],

    ],
];
