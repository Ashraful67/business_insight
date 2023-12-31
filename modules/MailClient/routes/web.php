<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\MailClient\Http\Controllers\MailTrackerController;
use Modules\MailClient\Http\Controllers\OAuthEmailAccountController;

Route::get('mt/o/{hash}', [MailTrackerController::class, 'opens'])->name('mail-tracker.open');
Route::get('mt/l', [MailTrackerController::class, 'link'])->name('mail-tracker.link');

Route::middleware('auth')->group(function () {
    Route::get('/mail/accounts/{type}/{provider}/connect', [OAuthEmailAccountController::class, 'connect']);
});
