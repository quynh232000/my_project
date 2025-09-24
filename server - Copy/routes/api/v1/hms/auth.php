<?php
use App\Http\Controllers\Api\V1\Hms\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('hms/auth/login', [AuthController::class, 'login'])->name('hms.auth.login');
Route::post('hms/auth/refresh', [AuthController::class, 'refresh'])->name('hms.auth.refresh');
Route::post('hms/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('hms.auth.forgot-password');
Route::post('hms/auth/reset-password', [AuthController::class, 'resetPassword'])->name('hms.auth.reset-password');
Route::post('hms/auth/logout', [AuthController::class, 'logout'])->name('hms.auth.logout');
Route::post('hms/auth/verify-reset-code', [AuthController::class, 'verifyResetCode'])->name('hms.auth.verify-reset-code');
// For authenticated users only
Route::middleware(['hms','throttle:300,1'])->group(function () {
   Route::get('hms/auth/me', [AuthController::class, 'me'])->name('hms.auth.me');
 });