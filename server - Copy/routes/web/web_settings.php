<?php
use App\Http\Controllers\Admin\NotifyController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SettingController::class, 'index'])->name('settings');
Route::get('/update/{id}', [SettingController::class, 'index'])->name('settings.update');
Route::post('/_update/{id}', [SettingController::class, 'update'])->name('settings._update');
Route::post('/add_new', [SettingController::class, 'add_new'])->name('settings.add_new');