<?php

use App\Http\Controllers\Api\V1\Hotel\ChainController;
use Illuminate\Support\Facades\Route;

Route::apiResource('chain', ChainController::class)->only(['index']);