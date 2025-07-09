<?php
use App\Http\Controllers\Api\V1\Hms\PolicyOtherController;
use Illuminate\Support\Facades\Route;



Route::name('hms.policy-other.')->group(function () {
    Route::apiResource('policy-other', PolicyOtherController::class)->only(['index','store','show']);
});