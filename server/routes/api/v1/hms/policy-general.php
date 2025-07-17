<?php
use App\Http\Controllers\Api\V1\Hms\PolicyGeneralController;
use Illuminate\Support\Facades\Route;

Route::name('hms.policy-general.')->group(function () {
    Route::apiResource('policy-general', PolicyGeneralController::class)->only(['index','store']);
});