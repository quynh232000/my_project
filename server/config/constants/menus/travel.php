<?php
$base = basename(__FILE__, '.php');
return [
    'title'     => 'Travel',
    'icon'      => 'ki-outline ki-rocket',
    'name_route' => $base,
    'sub'       => [
        // tour
        [
            'title'         => 'Tours',
            'name_route'    => $base . '.tour',
            'sub'           => [
                                ['title' => 'Tours Listing', 'route' => $base.'.tour.index'],
                                ['title' => 'Add Tours', 'route' => $base.'.tour.create'],
                            ],
        ],

        // news
        [
            'title'         => 'News',
            'name_route'    => $base . '.news',
            'sub'           => [
                                ['title' => 'News Listing', 'route' => $base.'.news.index'],
                                ['title' => 'Add News', 'route' => $base.'.news.create'],
                            ],
        ],


    ],
];
