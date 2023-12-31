<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\Billable\Http\Controllers\Api\ActiveProductController;
use Modules\Billable\Http\Controllers\Api\BillableController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/{resource}/{resourceId}/billable', [BillableController::class, 'handle']);

    Route::get('/products/active', [ActiveProductController::class, 'handle']);
});
