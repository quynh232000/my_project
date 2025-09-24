<?php
$base = basename(__FILE__, '.php');
return [
    'title'     => 'Course',
    'icon'      => 'ki-outline ki-briefcase',
    'name_route' => $base,
    'sub'       => [
        // category
        [
            'title'         => 'Categories',
            'name_route'    => $base . '.category',
            'sub'           => [
                                ['title' => 'Categories Listing', 'route' => $base.'.category.index'],
                                ['title' => 'Add Categories', 'route' => $base.'.category.create'],
                            ],
        ],

        // level
        [
            'title'         => 'Levels',
            'name_route'    => $base . '.level',
            'sub'           => [
                                ['title' => 'Levels Listing', 'route' => $base.'.level.index'],
                                ['title' => 'Add Levels', 'route' => $base.'.level.create'],
                            ],
        ],
        // course
        [
            'title'         => 'Courses',
            'name_route'    => $base . '.course',
            'sub'           => [
                                ['title' => 'Courses Listing', 'route' => $base.'.course.index'],
                                ['title' => 'Add Courses', 'route' => $base.'.course.create'],
                            ],
        ],


    ],
];
