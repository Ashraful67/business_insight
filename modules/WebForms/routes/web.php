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
use Modules\WebForms\Http\Controllers\WebFormController;

Route::withoutMiddleware([
    PreventRequestsWhenMigrationNeeded::class,
    PreventRequestsWhenUpdateNotFinished::class,
])->group(function () {
    Route::get('/forms/f/{uuid}', [WebFormController::class, 'show'])->name('webform.view');
    Route::post('/forms/f/{uuid}', [WebFormController::class, 'store'])->name('webform.process');
});
