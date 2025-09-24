<?php
use App\Http\Controllers\Api\V1\Hms\BankController;
use Illuminate\Support\Facades\Route;

Route::name('hms.bank.')->group(function () {
    Route::apiResource('bank', BankController::class)->only(['index']);
});