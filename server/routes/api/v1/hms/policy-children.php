<?php
use App\Http\Controllers\Api\V1\Hms\PolicyChildrenController;
use Illuminate\Support\Facades\Route;


Route::name('hms.policy-children.')->group(function () {
    Route::apiResource('policy-children', PolicyChildrenController::class)->only(['index','store','destroy']);
});