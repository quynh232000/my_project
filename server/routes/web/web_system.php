<?php
use App\Http\Controllers\Admin\SystemController;
use Illuminate\Support\Facades\Route;


Route::prefix('address')->group(function(){
    Route::get('/add_province', [SystemController::class, 'add_province']);
    Route::get('/add_district', [SystemController::class, 'add_district']);
    Route::get('/add_ward', [SystemController::class, 'add_ward']);

});
