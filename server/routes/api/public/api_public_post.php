<?php

use App\Http\Controllers\Api\Public\PostController;
use App\Http\Controllers\Api\Public\PublicController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/detail/{slug}', [PublicController::class, 'getPostBySlug']);
Route::get('/category_post', [PublicController::class, 'getPostCategory']);
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/create_post', [PublicController::class, 'createPost']);
    Route::post('/create_category_post', [PublicController::class, 'createCategoryPost']);
    Route::delete('/delete_entity/{type}/{id}', [PublicController::class, 'deleteEntityById']);
    Route::patch('/recover_entity/{type}/{id}', [PublicController::class, 'recoverEntityById']);
    Route::post('/edit_post/{id}', [PublicController::class, "editPostById"]);
    Route::post('/edit_category_post/{id}', [PublicController::class, 'editCategoryPostById']);
    Route::get('/my_post', [PublicController::class, 'my_post']);
    Route::get('/post_slug_shop/{id}', [PublicController::class, 'getPostByIDPostShop']);


});
Route::get('/sidebar/{post_type}', [PostController::class, 'post_sidebar']);
Route::get('/{post_type}/list', [PostController::class, 'index']);
Route::get('/{type}', [PublicController::class, 'getPostFilter']);
