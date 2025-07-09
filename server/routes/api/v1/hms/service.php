<?php
use App\Http\Controllers\Api\V1\Hms\ServiceController;
use Illuminate\Support\Facades\Route;


Route::name('hms.service.')->group(function () {
    Route::apiResource('service', ServiceController::class)->only(['index']);
});