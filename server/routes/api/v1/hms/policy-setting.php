<?php
use App\Http\Controllers\Api\V1\Hms\PolicySettingController;
use Illuminate\Support\Facades\Route;

// Route::get('/policy-setting/index', [PolicySettingController::class, 'index'])->name('hms.policy-setting.index');

Route::name('hms.policy-setting.')->group(function () {
    Route::apiResource('policy-setting', PolicySettingController::class)->only(['index']);
});