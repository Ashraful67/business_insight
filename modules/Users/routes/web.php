<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Middleware\PreventRequestsWhenMigrationNeeded;
use Modules\Core\Http\Middleware\PreventRequestsWhenUpdateNotFinished;
use Modules\Users\Http\Controllers\UserInvitationAcceptController;

Route::withoutMiddleware([
    PreventRequestsWhenMigrationNeeded::class,
    PreventRequestsWhenUpdateNotFinished::class,
])->group(function () {
    Route::get('/invitation/{token}', [UserInvitationAcceptController::class, 'show'])->name('invitation.show');
    Route::post('/invitation/{token}', [UserInvitationAcceptController::class, 'accept']);
});
