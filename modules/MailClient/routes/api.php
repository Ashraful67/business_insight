<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\MailClient\Http\Controllers\Api\EmailAccountConnectionTestController;
use Modules\MailClient\Http\Controllers\Api\EmailAccountController;
use Modules\MailClient\Http\Controllers\Api\EmailAccountMessagesController;
use Modules\MailClient\Http\Controllers\Api\EmailAccountPrimaryStateController;
use Modules\MailClient\Http\Controllers\Api\EmailAccountSync;
use Modules\MailClient\Http\Controllers\Api\EmailAccountSyncStateController;
use Modules\MailClient\Http\Controllers\Api\PersonalEmailAccountController;
use Modules\MailClient\Http\Controllers\Api\PredefinedMailTemplateController;
use Modules\MailClient\Http\Controllers\Api\SharedEmailAccountController;

Route::middleware('auth:sanctum')->group(function () {
    // Email accounts routes
    Route::prefix('mail/accounts')->group(function () {
        // Email accounts management
        Route::get('{account}/sync', EmailAccountSync::class);
        Route::get('unread', [EmailAccountController::class, 'unread']);

        // The GET route for all shared accounts
        Route::get('shared', SharedEmailAccountController::class)->middleware('permission:access shared inbox');

        // The GET route for all logged in user personal mail accounts
        Route::get('personal', PersonalEmailAccountController::class);

        // Test connection route
        Route::post('connection', [EmailAccountConnectionTestController::class, 'handle']);

        Route::put('{account}/primary', [EmailAccountPrimaryStateController::class, 'update']);
        Route::delete('primary', [EmailAccountPrimaryStateController::class, 'destroy']);
        Route::post('{account}/sync/enable', [EmailAccountSyncStateController::class, 'enable']);
        Route::post('{account}/sync/disable', [EmailAccountSyncStateController::class, 'disable']);
    });

    Route::apiResource('/mail/accounts', EmailAccountController::class);

    Route::prefix('emails')->group(function () {
        Route::post('{message}/read', [EmailAccountMessagesController::class, 'read']);
        Route::post('{message}/unread', [EmailAccountMessagesController::class, 'unread']);
        Route::delete('{message}', [EmailAccountMessagesController::class, 'destroy']);
        // reply method is used to check in MessageRequest
        Route::post('{message}/reply', [EmailAccountMessagesController::class, 'reply']);
        Route::post('{message}/forward', [EmailAccountMessagesController::class, 'forward']);
    });

    Route::prefix('inbox')->group(function () {
        Route::get('emails/folders/{folder_id}/{message}', [EmailAccountMessagesController::class, 'show']);
        Route::post('emails/{account_id}', [EmailAccountMessagesController::class, 'create']);
        Route::get('emails/{account_id}/{folder_id}', [EmailAccountMessagesController::class, 'index']);
    });

    // Mail templates management
    Route::apiResource('mails/templates', PredefinedMailTemplateController::class);
});
