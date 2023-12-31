<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Modules\Activities\Http\Controllers\OAuthCalendarController;
use Modules\Activities\Http\Controllers\OutlookCalendarWebhookController;

Route::withoutMiddleware(VerifyCsrfToken::class)->group(function () {
    Route::post('/webhook/outlook-calendar', [OutlookCalendarWebhookController::class, 'handle']);
});

Route::middleware('auth')->group(function () {
    Route::get('/calendar/sync/{provider}/connect', [OAuthCalendarController::class, 'connect']);
});
