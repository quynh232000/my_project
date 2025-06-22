<?php
return  [

    'prefix' => basename(__FILE__, '.php'),
    'label' => 'Api Portfolio',
    'middleware' => [],
    'routes' => [
        [
            'controller'    =>  \App\Http\Controllers\Api\V1\Portfolio\DataInfoController::class,
            'uri'           => 'data',
            'name'          => basename(__FILE__, '.php').'.data',
            'methods'       => ['post'],
            'action'        => 'data'
        ],
         [
            'controller'    =>  \App\Http\Controllers\Api\V1\Portfolio\DataInfoController::class,
            'uri'           => 'contact',
            'name'          => basename(__FILE__, '.php').'.contact',
            'methods'       => ['post'],
            'action'        => 'contact'
        ],
    ]
];
