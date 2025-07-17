<?php

use App\Http\Controllers\Api\V1\Hotel\PartnerRegisterController;
use Illuminate\Support\Facades\Route;

Route::apiResource('partner-register', PartnerRegisterController::class)->only(['store']);

