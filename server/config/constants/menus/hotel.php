<?php
$base = basename(__FILE__, '.php');
return [
    'title'         => 'Hotel',
    'icon'          => 'ki-outline ki-rocket',
    'name_route'    => $base,
    'sub'       => [
        // attribute
        [
            'title'         => 'Settings',
            'name_route'    => $base . '.tour',
            'sub'           => [
                ['title' => 'Attribute Listing', 'route' => $base . '.attribute.index'],
                ['title' => 'Banks Listing', 'route' => $base . '.bank.index'],
                ['title' => 'Chains Listing', 'route' => $base . '.chain.index'],
                ['title' => 'Accounts Listing', 'route' => $base . '.customer.index'],
                ['title' => 'Policy Settings', 'route' => $base . '.policy-setting.index'],
                ['title' => 'Room Types', 'route' => $base . '.room-type.index'],
                ['title' => 'Service Listing', 'route' => $base . '.service.index'],
                ['title' => 'Partner Register', 'route' => $base . '.partner-register.index'],
                ['title' => 'Accounts Listing', 'route' => $base . '.customer.index'],
                ['title' => 'Payment Info Listing', 'route' => $base . '.payment-info.index'],
            ],
        ],
        [
            'title'         => 'Hotels',
            'name_route'    => $base . '.hotel',
            'sub'           => [
                ['title' => 'Hotels Listing', 'route' => $base . '.hotel.index'],
                ['title' => 'Reviews Listing', 'route' => $base . '.review.index'],
            ],
        ],


    ],
];
