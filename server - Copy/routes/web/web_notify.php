<?php
use App\Http\Controllers\Admin\NotifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NotifyController::class, 'index'])->name('notify.list');
Route::get('/show/{id}', [NotifyController::class, 'show'])->name('notify.show');
Route::get('/history', [NotifyController::class, 'notify_history'])->name('notify.list.history');
Route::get('/history/{notify_id}', [NotifyController::class, 'notify_history'])->name('notify.history.detail');
Route::get('/add', [NotifyController::class, 'notify_add'])->name('notify.add');
Route::post('/add', [NotifyController::class, 'store'])->name('notify.store');
