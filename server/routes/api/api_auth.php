<?php

use App\Http\Controllers\Api\Auth\UsersController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersController::class,'index']);
Route::post('register', [UsersController::class, 'register']);
Route::get('test', [UsersController::class, 'test']);
Route::post('check-email', [UsersController::class, 'checkEmail']);
Route::post('verify-email', [UsersController::class, 'verifyEmail']);
Route::post('login', [UsersController::class, 'login']);
Route::post('withgoogle', [UsersController::class, 'googleAuthentication']);
Route::post('forgotpassword', [UsersController::class, 'forgotpassword']);
Route::post('changenewpassword', [UsersController::class, 'changenewpassword']);
Route::post('refresh-token', [UsersController::class, 'refreshToken']);
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('me', [UsersController::class, 'me']);
});
Route::group(['prefix' => '/user/','middleware'=>JwtMiddleware::class], function () {
    require __DIR__ . '/auth/auth_user.php';
});