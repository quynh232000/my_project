<?php

use App\Http\Controllers\Api\V1\Hotel\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/post/list', [PostController::class, 'list'])->name('post.list');
Route::post('/post/detail', [PostController::class, 'detail'])->name('post.detail');
Route::post('/post/meta', [PostController::class, 'meta'])->name('post.meta');
