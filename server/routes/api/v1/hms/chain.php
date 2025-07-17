<?php
use App\Http\Controllers\Api\V1\Hms\ChainController;
use Illuminate\Support\Facades\Route;

Route::name('hms.chain.')->group(function () {
    Route::apiResource('chain', ChainController::class)->only(['index']);
});

