<?php
return [
    'title'     => 'E-Commerce',
    'icon'      => 'ki-outline ki-handcart',
    'sub'       => [
        [
            'title' => 'Dashboard',
            'route' => 'ecommerce.dassboard.index'
        ],
         [
            'title' => 'Category',
            'route' => 'ecommerce.category.index'
        ], [
            'title' => 'Product',
            'route' => 'ecommerce.product.index'
        ], [
            'title' => 'Orders',
            'route' => 'ecommerce.order.index'
        ], [
            'title' => 'Shipping',
            'route' => 'ecommerce.shipping.index'
        ],
        [
            'title' => 'Sales',
            'sub' => [
                ['title' => 'Orders Listing', 'route' => 'sales.orders'],
                ['title' => 'Order Details', 'route' => 'sales.details'],
                ['title' => 'Add Order', 'route' => 'sales.add'],
                ['title' => 'Edit Order', 'route' => 'sales.edit'],
            ],
        ],
       
    ],
];
