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
use Modules\Documents\Http\Controllers\DocumentController;

Route::withoutMiddleware([
    PreventRequestsWhenMigrationNeeded::class,
    PreventRequestsWhenUpdateNotFinished::class,
])->group(function () {
    Route::get('/d/{uuid}', [DocumentController::class, 'show'])->name('document.public');
    Route::get('/d/{uuid}/pdf', [DocumentController::class, 'pdf'])->name('document.pdf');
});
