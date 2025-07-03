<?php
return [
    'title'     => 'General',
    'icon'      => 'ki-outline ki-credit-cart',
    'name_route' => basename(__FILE__, '.php'),
    'sub'       => [
        [
            'title' => 'Account',
             'name_route' => basename(__FILE__, '.php').'.user',
            'sub' => [
                ['title' => 'Account Listing', 'route' => 'admin.user.index'],
                ['title' => 'Add user', 'route' => 'admin.user.create'],
            ],
        ],
        [
            'title' => 'Permission',
             'name_route' => basename(__FILE__, '.php').'.permission',
            'sub' => [
                ['title' => 'New Routes Listing', 'route' => 'admin.permission.new','icon' => 'fa-regular fa-square-plus text-warning'],
                ['title' => 'Permission Listing', 'route' => 'admin.permission.index'],
                ['title' => 'Role Listing', 'route' => 'admin.role.index'],
            ],
        ],
        [
            'title' => 'File Manager',
             'name_route' => basename(__FILE__, '.php').'.file-upload',
            'sub' => [
                ['title' => 'Files Listing', 'route' => 'admin.file-upload.index'],
            ],
        ],

    ],
];
