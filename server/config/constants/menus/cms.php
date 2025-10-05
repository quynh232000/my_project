<?php
$base = basename(__FILE__, '.php');
return [
    'title'         => 'Smart RMS',
    'icon'          => 'fa-solid fa-store',
    'name_route'    => $base,
    'sub'       => [
        // Auth
        [
            'title'         => 'Authentication',
            'name_route'    => $base . '.auth',
            'sub'           => [
                ['title' => 'Users', 'route' => $base . '.user.index'],
                ['title' => 'Roles', 'route' => $base . '.role.index'],
                ['title' => 'Permissions', 'route' => $base . '.permission.index'],
            ],
        ],
         [
            'title'         => 'Restaurants',
            'name_route'    => $base . '.retaurant',
            'sub'           => [
                ['title' => 'Restaurants', 'route' => $base . '.restaurant.index'],
                ['title' => 'Menu Categories', 'route' => $base . '.menu-category.index'],
                ['title' => 'Menu foods', 'route' => $base . '.menu-item.index'],
                
            ],
        ],
        // [
        //     'title'         => 'Settings',
        //     'name_route'    => $base . '.tour',
        //     'sub'           => [
        //         ['title' => 'Attribute Listing', 'route' => $base . '.attribute.index'],
        //         ['title' => 'Banks Listing', 'route' => $base . '.bank.index'],
        //         ['title' => 'Chains Listing', 'route' => $base . '.chain.index'],
        //         ['title' => 'Accounts Listing', 'route' => $base . '.customer.index'],
        //         ['title' => 'Policy Settings', 'route' => $base . '.policy-setting.index'],
        //         ['title' => 'Room Types', 'route' => $base . '.room-type.index'],
        //         ['title' => 'Service Listing', 'route' => $base . '.service.index'],
        //         ['title' => 'Partner Register', 'route' => $base . '.partner-register.index'],
        //         ['title' => 'Accounts Listing', 'route' => $base . '.customer.index'],
        //         ['title' => 'Payment Info Listing', 'route' => $base . '.payment-info.index'],
        //     ],
        // ],
        // [
        //     'title'         => 'Hotels',
        //     'name_route'    => $base . '.hotel',
        //     'sub'           => [
        //         ['title' => 'Hotels Listing', 'route' => $base . '.hotel.index'],
        //         ['title' => 'Reviews Listing', 'route' => $base . '.review.index'],
        //         ['title' => 'Hotel Categories', 'route' => $base . '.hotel-category.index'],
        //         ['title' => 'Posts', 'route' => $base . '.post.index'],
        //         ['title' => 'Posts Category', 'route' => $base . '.post-category.index'],
        //         ['title' => 'Banners', 'route' => $base . '.banner.index'],
        //     ],
        // ],


    ],
];
