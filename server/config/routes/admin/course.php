<?php
$base = basename(__FILE__, '.php');
return  [

    'prefix'        => $base,
    'label'         => 'Course',
    'middleware'    => [],
    'routes' => [
        // category
        [
            'type'          => 'resource',
            'uri'           => 'category',
            'controller'    =>  \App\Http\Controllers\Admin\Course\CategoryController::class,
            'name_prefix'   => $base . '.category',
            'only'          => ['index', 'edit', 'store', 'create','show', 'update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Course\CategoryController::class,
            'uri'           => $base . '/category/status/{status}/{id}',
            'name'          => $base . '.category.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Course\CategoryController::class,
            'uri'           => $base . '/category/confirm-delete',
            'name'          => $base . '.category.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // level
        [
            'type'          => 'resource',
            'uri'           => 'level',
            'controller'    =>  \App\Http\Controllers\Admin\Course\LevelController::class,
            'name_prefix'   => $base . '.level',
            'only'          => ['index', 'edit', 'store', 'create', 'show','update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Course\LevelController::class,
            'uri'           => $base . '/level/status/{status}/{id}',
            'name'          => $base . '.level.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Course\LevelController::class,
            'uri'           => $base . '/level/confirm-delete',
            'name'          => $base . '.level.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],
        // course
        [
            'type'          => 'resource',
            'uri'           => 'course',
            'controller'    =>  \App\Http\Controllers\Admin\Course\CourseController::class,
            'name_prefix'   => $base . '.course',
            'only'          => ['index', 'edit', 'store', 'create','show', 'update', 'destroy'],
        ],
         [
            'controller'    =>   \App\Http\Controllers\Admin\Course\CourseController::class,
            'uri'           => $base . '/course/status/{status}/{id}',
            'name'          => $base . '.course.status',
            'methods'       => ['get'],
            'action'        => 'status',
        ],
        [
            'controller'    =>   \App\Http\Controllers\Admin\Course\CourseController::class,
            'uri'           => $base . '/course/confirm-delete',
            'name'          => $base . '.course.confirm-delete',
            'methods'       => ['post'],
            'action'        => 'confirmDelete',
        ],

    ]

];
