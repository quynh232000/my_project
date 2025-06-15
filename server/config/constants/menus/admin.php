<?php
return [
    'title'     => 'General',
    'icon'      => 'ki-outline ki-credit-cart',
    'sub'       => [
        // [
        //     'title' => 'File',
        //     'sub' => [
        //         ['title' => 'File Listing', 'route' => 'admin.file.index'],
        //         ['title' => 'Add File', 'route' => 'admin.file.create'],
        //     ],
        // ],
        [
            'title' => 'Account',
            'sub' => [
                ['title' => 'Account Listing', 'route' => 'admin.user.index'],
                ['title' => 'Add user', 'route' => 'admin.user.create'],
            ],
        ],
        [
            'title' => 'Permission',
            'sub' => [
                // ['title' => 'Resource Listing', 'route' => 'admin.resrouce.index'],
                ['title' => 'Role Listing', 'route' => 'admin.role.index'],
                ['title' => 'Permission Listing', 'route' => 'admin.permission.index'],
            ],
        ],
        [
            'title' => 'File Manager',
            'sub' => [
                ['title' => 'Files Listing', 'route' => 'admin.file-upload.index'],
            ],
        ],

    ],
];
