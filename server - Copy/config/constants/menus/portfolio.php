<?php
return [
    'title'     => 'Portfolio',
    'icon'      => 'ki-outline ki-chart',
    'name_route' => basename(__FILE__, '.php'),
    'sub'       => [

        [
            'title' => 'Category',
            'name_route' => basename(__FILE__, '.php').'.category',
            'sub' => [
                ['title' => 'Category Listing', 'route' => 'portfolio.category.index'],
                ['title' => 'Add Category', 'route' => 'portfolio.category.create'],
            ],
        ],
         [
            'title' => 'Icon',
            'name_route' => basename(__FILE__, '.php').'.icon',
            'sub' => [
                ['title' => 'Icon Listing', 'route' => 'portfolio.icon.index'],
                ['title' => 'Add Icon', 'route' => 'portfolio.icon.create'],
            ],
        ],
         [
            'title' => 'Images Yourself',
            'name_route' => basename(__FILE__, '.php').'.image',
            'sub' => [
                ['title' => 'Image Listing', 'route' => 'portfolio.image.index'],
                ['title' => 'Add Image', 'route' => 'portfolio.image.create'],
            ],
        ],
         [
            'title' => 'Infomation',
            'name_route' => basename(__FILE__, '.php').'.data-info',
            'sub' => [
                ['title' => 'Infomation Listing', 'route' => 'portfolio.data-info.index'],
                ['title' => 'Add Infomation', 'route' => 'portfolio.data-info.create'],
            ],
        ],
         [
            'title' => 'Projects',
            'name_route' => basename(__FILE__, '.php').'.project',
            'sub' => [
                ['title' => 'Projects Listing', 'route' => 'portfolio.project.index'],
                ['title' => 'Add Projects', 'route' => 'portfolio.project.create'],
            ],
        ],
         [
            'title' => 'Blogs',
            'name_route' => basename(__FILE__, '.php').'.blog',
            'sub' => [
                ['title' => 'Blogs Listing', 'route' => 'portfolio.blog.index'],
                ['title' => 'Add Blogs', 'route' => 'portfolio.blog.create'],
            ],
        ],
         [
            'title' => 'Contacts',
            'name_route' => basename(__FILE__, '.php').'.contact',
            'sub' => [
                ['title' => 'Contacts Listing', 'route' => 'portfolio.contact.index'],
            ],
        ],

    ],
];
