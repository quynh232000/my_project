<?php
use App\Http\Middleware\IsLoginMiddleware;

return  [

    'prefix' => '/',
    'label' => 'Quin Admin',
    'middleware' => [IsLoginMiddleware::class],
    'routes' => [

        [
            'controller'    =>  \App\Http\Controllers\Admin\Admin\DashboardController::class,
            'uri'           => '/',
            'name'          => 'dashboard',
            'methods'       => ['get'],
            'action'        => 'dashboard'
        ],




    ]

];
