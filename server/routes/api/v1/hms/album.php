<?php
use App\Http\Controllers\Api\V1\Hms\AlbumController;
use Illuminate\Support\Facades\Route;

Route::name('hms.album.')->group(function () {
    Route::get('album/list', [AlbumController::class, 'list'])->name('list');
    Route::post('album/edit', [AlbumController::class, 'edit'])->name('edit');
    Route::delete('album/delete', [AlbumController::class, 'delete'])->name('delete');
    Route::apiResource('album', AlbumController::class)->only(['index','store']);
});

