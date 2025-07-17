<?php
use App\Http\Controllers\Api\V1\Hms\AttributeController;
use Illuminate\Support\Facades\Route;


Route::name('hms.attribute.')->group(function () {
    Route::apiResource('attribute', AttributeController::class)->only(['index']);
});