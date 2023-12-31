<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\Translator\Http\Controllers\Api\TranslationController;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('translation')->group(function () {
        Route::post('/', [TranslationController::class, 'store']);
        Route::get('/{locale}', [TranslationController::class, 'index']);
        Route::put('/{locale}/{group}', [TranslationController::class, 'update']);
    });
});
