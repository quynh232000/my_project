<?php
use App\Http\Controllers\Api\V1\Hms\BankBranchController;
use Illuminate\Support\Facades\Route;

Route::name('hms.bank-branch.')->group(function () {
    Route::apiResource('bank-branch', BankBranchController::class)->only(['index']);
});