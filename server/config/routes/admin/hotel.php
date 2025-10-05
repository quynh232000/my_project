<?php

use App\Http\Middleware\IsLoginMiddleware;

$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Hotel',
    'middleware'    => [IsLoginMiddleware::class],
    'routes'        => [
        // settting_routes
        // attribute_route
        [
            'type'          => 'resource',
            'uri'           => 'attribute',
            'controller'    =>  \App\Http\Controllers\Hotel\AttributeController::class,
            'name_prefix'   => $base . '.attribute',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\AttributeController::class,
            'uri'           => $base . '/attribute/status/{status}/{id}',
            'name'          => $base . '.attribute.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\AttributeController::class,
            'uri'           => $base . '/attribute/confirm-delete',
            'name'          => $base . '.attribute.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\AttributeController::class,
            'uri'           => $base . '/attribute/move/{act}/{id}',
            'name'          => $base . '.attribute.move',
            'methods'       => ['get'],
            'action'        => 'move',
        ],
        // bank_route
        [
            'type'          => 'resource',
            'uri'           => 'bank',
            'controller'    =>  \App\Http\Controllers\Hotel\BankController::class,
            'name_prefix'   => $base . '.bank',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\BankController::class,
            'uri'           => $base . '/bank/status/{status}/{id}',
            'name'          => $base . '.bank.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\BankController::class,
            'uri'           => $base . '/bank/confirm-delete',
            'name'          => $base . '.bank.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // chain_route
        [
            'type'          => 'resource',
            'uri'           => 'chain',
            'controller'    =>  \App\Http\Controllers\Hotel\ChainController::class,
            'name_prefix'   => $base . '.chain',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ChainController::class,
            'uri'           => $base . '/chain/status/{status}/{id}',
            'name'          => $base . '.chain.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ChainController::class,
            'uri'           => $base . '/chain/confirm-delete',
            'name'          => $base . '.chain.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // hotel-category_route
        [
            'type'          => 'resource',
            'uri'           => 'hotel-category',
            'controller'    =>  \App\Http\Controllers\Hotel\HotelCategoryController::class,
            'name_prefix'   => $base . '.hotel-category',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\HotelCategoryController::class,
            'uri'           => $base . '/hotel-category/status/{status}/{id}',
            'name'          => $base . '.hotel-category.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\HotelCategoryController::class,
            'uri'           => $base . '/hotel-category/confirm-delete',
            'name'          => $base . '.hotel-category.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\HotelCategoryController::class,
            'uri'           => $base . '/hotel-category/move/{act}/{id}',
            'name'          => $base . '.hotel-category.move',
            'methods'       => ['get'],
            'action'        => 'move',
        ],
        // customer_route
        [
            'type'          => 'resource',
            'uri'           => 'customer',
            'controller'    =>  \App\Http\Controllers\Hotel\CustomerController::class,
            'name_prefix'   => $base . '.customer',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\CustomerController::class,
            'uri'           => $base . '/customer/status/{status}/{id}',
            'name'          => $base . '.customer.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\CustomerController::class,
            'uri'           => $base . '/customer/confirm-delete',
            'name'          => $base . '.customer.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // hotel_route
        [
            'type'          => 'resource',
            'uri'           => 'hotel',
            'controller'    =>  \App\Http\Controllers\Hotel\HotelController::class,
            'name_prefix'   => $base . '.hotel',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\HotelController::class,
            'uri'           => $base . '/hotel/status/{status}/{id}',
            'name'          => $base . '.hotel.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\HotelController::class,
            'uri'           => $base . '/hotel/confirm-delete',
            'name'          => $base . '.hotel.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // policy-setting_route
        [
            'type'          => 'resource',
            'uri'           => 'policy-setting',
            'controller'    =>  \App\Http\Controllers\Hotel\PolicySettingController::class,
            'name_prefix'   => $base . '.policy-setting',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PolicySettingController::class,
            'uri'           => $base . '/policy-setting/status/{status}/{id}',
            'name'          => $base . '.policy-setting.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PolicySettingController::class,
            'uri'           => $base . '/policy-setting/confirm-delete',
            'name'          => $base . '.policy-setting.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // room-type_route
        [
            'type'          => 'resource',
            'uri'           => 'room-type',
            'controller'    =>  \App\Http\Controllers\Hotel\RoomTypeController::class,
            'name_prefix'   => $base . '.room-type',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\RoomTypeController::class,
            'uri'           => $base . '/room-type/status/{status}/{id}',
            'name'          => $base . '.room-type.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\RoomTypeController::class,
            'uri'           => $base . '/room-type/confirm-delete',
            'name'          => $base . '.room-type.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // service_route
        [
            'type'          => 'resource',
            'uri'           => 'service',
            'controller'    =>  \App\Http\Controllers\Hotel\ServiceController::class,
            'name_prefix'   => $base . '.service',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ServiceController::class,
            'uri'           => $base . '/service/status/{status}/{id}',
            'name'          => $base . '.service.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ServiceController::class,
            'uri'           => $base . '/service/confirm-delete',
            'name'          => $base . '.service.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ServiceController::class,
            'uri'           => $base . '/service/move/{act}/{id}',
            'name'          => $base . '.service.move',
            'methods'       => ['get'],
            'action'        => 'move',
        ],
        // review_route
        [
            'type'          => 'resource',
            'uri'           => 'review',
            'controller'    =>  \App\Http\Controllers\Hotel\ReviewController::class,
            'name_prefix'   => $base . '.review',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ReviewController::class,
            'uri'           => $base . '/review/status/{status}/{id}',
            'name'          => $base . '.review.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\ReviewController::class,
            'uri'           => $base . '/review/confirm-delete',
            'name'          => $base . '.review.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // partner-register_route
        [
            'type'          => 'resource',
            'uri'           => 'partner-register',
            'controller'    =>  \App\Http\Controllers\Hotel\PartnerRegisterController::class,
            'name_prefix'   => $base . '.partner-register',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PartnerRegisterController::class,
            'uri'           => $base . '/partner-register/status/{status}/{id}',
            'name'          => $base . '.partner-register.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PartnerRegisterController::class,
            'uri'           => $base . '/partner-register/confirm-delete',
            'name'          => $base . '.partner-register.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PartnerRegisterController::class,
            'uri'           => $base . '/partner-register/confirm-choose',
            'name'          => $base . '.partner-register.confirm-choose',
            'methods'       => ['post'],
            'action'        => 'confirmChoose',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PartnerRegisterController::class,
            'uri'           => $base . '/partner-register/choose',
            'name'          => $base . '.partner-register.choose',
            'methods'       => ['post'],
            'action'        => 'choose',
        ],
        // payment-info_route
        [
            'type'          => 'resource',
            'uri'           => 'payment-info',
            'controller'    =>  \App\Http\Controllers\Hotel\PaymentInfoController::class,
            'name_prefix'   => $base . '.payment-info',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PaymentInfoController::class,
            'uri'           => $base . '/payment-info/status/{status}/{id}',
            'name'          => $base . '.payment-info.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PaymentInfoController::class,
            'uri'           => $base . '/payment-info/confirm-delete',
            'name'          => $base . '.payment-info.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PaymentInfoController::class,
            'uri'           => $base . '/payment-info/confirm-choose',
            'name'          => $base . '.payment-info.confirm-choose',
            'methods'       => ['post'],
            'action'        => 'confirmChoose',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PaymentInfoController::class,
            'uri'           => $base . '/payment-info/choose',
            'name'          => $base . '.payment-info.choose',
            'methods'       => ['post'],
            'action'        => 'choose',
        ],
        // post_route
        [
            'type'          => 'resource',
            'uri'           => 'post',
            'controller'    =>  \App\Http\Controllers\Hotel\PostController::class,
            'name_prefix'   => $base . '.post',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PostController::class,
            'uri'           => $base . '/post/status/{status}/{id}',
            'name'          => $base . '.post.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PostController::class,
            'uri'           => $base . '/post/confirm-delete',
            'name'          => $base . '.post.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // post-category_route
        [
            'type'          => 'resource',
            'uri'           => 'post-category',
            'controller'    =>  \App\Http\Controllers\Hotel\PostCategoryController::class,
            'name_prefix'   => $base . '.post-category',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PostCategoryController::class,
            'uri'           => $base . '/post-category/status/{status}/{id}',
            'name'          => $base . '.post-category.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PostCategoryController::class,
            'uri'           => $base . '/post-category/confirm-delete',
            'name'          => $base . '.post-category.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\PostCategoryController::class,
            'uri'           => $base . '/post-category/move/{act}/{id}',
            'name'          => $base . '.post-category.move',
            'methods'       => ['get'],
            'action'        => 'move',
        ],
        // banner_route
        [
            'type'          => 'resource',
            'uri'           => 'banner',
            'controller'    =>  \App\Http\Controllers\Hotel\BannerController::class,
            'name_prefix'   => $base . '.banner',
            'only'          => ['index', 'edit', 'store', 'create', 'show', 'update', 'destroy'],
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\BannerController::class,
            'uri'           => $base . '/banner/status/{status}/{id}',
            'name'          => $base . '.banner.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Hotel\BannerController::class,
            'uri'           => $base . '/banner/confirm-delete',
            'name'          => $base . '.banner.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],

    ]

];
