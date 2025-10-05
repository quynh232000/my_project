<?php

use App\Http\Controllers\Api\V1\Hotel\PostCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/post-category/list', [PostCategoryController::class, 'list'])->name('post-category.list');
Route::post('/post-category/detail', [PostCategoryController::class, 'detail'])->name('post-category.detail');
Route::post('/post-category/meta', [PostCategoryController::class, 'meta'])->name('post-category.meta');
