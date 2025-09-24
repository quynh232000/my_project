<?php
use App\Http\Controllers\Api\V1\Hms\PolicyCancellationController;
use Illuminate\Support\Facades\Route;

Route::name('hms.policy-cancellation.')->group(function () {
    Route::put('policy-cancellation/toggle-status/{policy_cancellation}', [PolicyCancellationController::class, 'toggleStatus'])->name('toggle-status');
    Route::apiResource('policy-cancellation', PolicyCancellationController::class)->only(['index','show','store','destroy']);
});