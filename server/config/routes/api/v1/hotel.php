<?php

use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Hotel',
    'middleware'    => [],
    'routes'        => [
        // settting_routes
        // attribute_route
        // [
        //     'type'          => 'resource',
        //     'uri'           => 'attribute',
        //     'controller'    =>  \App\Http\Controllers\Hotel\AttributeController::class,
        //     'name_prefix'   => $base . '.attribute',
        //     'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        // ],
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\Hotel\PartnerRegisterController::class,
            'uri'           =>  'partner-register/create',
            'name'          =>  $base . '.partner-register.store',
            'methods'       => ['post'],
            'action'        => 'store',
        ],
    ]
];
