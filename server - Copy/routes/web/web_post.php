<?php
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('post.list');
Route::get('/settings', [PostController::class, 'settings'])->name('post.settings');

Route::prefix('post_type')->group(function () {
    Route::post('/', [PostController::class, '_post_type_add'])->name('post.setting.type._add');
    Route::get('/delete/{id}', [PostController::class, 'post_type_delete'])->name('post.setting.type.delete');
});
Route::prefix('tag')->group(function () {
    Route::post('/', [PostController::class, 'tag_add'])->name('post.setting.tag._add');
    Route::get('/delete/{id}', [PostController::class, 'tag_delete'])->name('post.setting.tag.delete');
});
Route::prefix('category')->group(function () {
    Route::get('/', [PostController::class, 'category'])->name('post.category');
    Route::post('/', [PostController::class, '_category'])->name('post.category._add');
    Route::post('/update/{id}', [PostController::class, '_category'])->name('post.category._update');
    Route::get('/delete/{id}', [PostController::class, 'category_delete'])->name('post.category.delete');
    Route::get('/{id}', [PostController::class, 'category'])->name('post.category.update');
});
Route::get('/add', [PostController::class, 'post_add'])->name('post.add');
Route::post('/add', [PostController::class, '_post_add'])->name('post._add');
Route::get('/update/{id}', [PostController::class, 'post_add'])->name('post.update');
Route::post('/update/{id}', [PostController::class, '_post_add'])->name('post._update');
Route::get('/delete/{id}', [PostController::class, 'post_delete'])->name('post.delete');
Route::get('/active_all', [PostController::class, 'post_active_all'])->name('post.active_all');
Route::get('/active/{id}', [PostController::class, 'post_active'])->name('post.active');
Route::post('/is_show/{id}', [PostController::class, 'is_show'])->name('post.is_show');


