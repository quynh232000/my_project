<?php

use App\Http\Middleware\HmsMiddleware;
use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'General',
    'middleware'    => [],
    'routes'        => [
        // province_route
        [
            'controller'    =>   \App\Http\Controllers\Api\V1\General\CountryController::class,
            'uri'           =>   'country/address',
            'name'          =>   'country.address',
            'methods'       => ['post'],
            'action'        => 'address',
        ],


    ]
];
