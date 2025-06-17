<?php
return [
    'title'     => 'Portfolio',
    'icon'      => 'ki-outline ki-chart',
    'sub'       => [
        // [
        //     'title' => 'Dashboard',
        //     'route' => 'ecommerce.dassboard.index'
        // ],
        //  [
        //     'title' => 'Category',
        //     'route' => 'ecommerce.category.index'
        // ], [
        //     'title' => 'Product',
        //     'route' => 'ecommerce.product.index'
        // ], [
        //     'title' => 'Orders',
        //     'route' => 'ecommerce.order.index'
        // ], [
        //     'title' => 'Shipping',
        //     'route' => 'ecommerce.shipping.index'
        // ],
        [
            'title' => 'Category',
            'sub' => [
                ['title' => 'Category Listing', 'route' => 'portfolio.category.index'],
                ['title' => 'Add Category', 'route' => 'portfolio.category.create'],
            ],
        ],
         [
            'title' => 'Icon',
            'sub' => [
                ['title' => 'Icon Listing', 'route' => 'portfolio.icon.index'],
                ['title' => 'Add Icon', 'route' => 'portfolio.icon.create'],
            ],
        ],
         [
            'title' => 'Images Yourself',
            'sub' => [
                ['title' => 'Image Listing', 'route' => 'portfolio.image.index'],
                ['title' => 'Add Image', 'route' => 'portfolio.image.create'],
            ],
        ],
         [
            'title' => 'Infomation',
            'sub' => [
                ['title' => 'Infomation Listing', 'route' => 'portfolio.data-info.index'],
                ['title' => 'Add i', 'route' => 'portfolio.data-info.create'],
            ],
        ],
         [
            'title' => 'Projects',
            'sub' => [
                ['title' => 'Projects Listing', 'route' => 'portfolio.project.index'],
                ['title' => 'Add Projects', 'route' => 'portfolio.project.create'],
            ],
        ],

    ],
];
