<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\Activities\Http\Controllers\Api\ActivityController;
use Modules\Activities\Http\Controllers\Api\ActivityStateController;
use Modules\Activities\Http\Controllers\Api\CalendarOAuthController;

Route::middleware('auth:sanctum')->group(function () {
    // Activity routes
    Route::get('/activities/{activity}/ics', [ActivityController::class, 'downloadICS']);
    Route::post('/activities/{activity}/complete', [ActivityStateController::class, 'complete']);
    Route::post('/activities/{activity}/incomplete', [ActivityStateController::class, 'incomplete']);

    // Calendar routes
    Route::prefix('calendar')->group(function () {
        Route::get('/account', [CalendarOAuthController::class, 'index']);
        Route::post('/account', [CalendarOAuthController::class, 'save']);
        Route::delete('/account', [CalendarOAuthController::class, 'destroy']);
    });

    Route::get('/calendars/{account}', [CalendarOAuthController::class, 'calendars']);
});
