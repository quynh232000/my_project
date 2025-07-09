<?php
use App\Http\Controllers\Api\V1\Hms\LanguageController;
use Illuminate\Support\Facades\Route;

Route::name('hms.language.')->group(function () {
    Route::apiResource('language', LanguageController::class)->only(['index']);
});