<?php

use App\Http\Controllers\Admin\LiveController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LiveController::class, 'index'])->name('live.index');
Route::get('/delete/{id}', [LiveController::class, 'delete'])->name('live.delete');
Route::get('/{id}/{status}', [LiveController::class, 'status'])->name('live.status');
