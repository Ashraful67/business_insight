<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\Api\IssueTokenController;
use Modules\Users\Http\Controllers\Api\NotificationController;
use Modules\Users\Http\Controllers\Api\PersonalAccessTokenController;
use Modules\Users\Http\Controllers\Api\ProfileController;
use Modules\Users\Http\Controllers\Api\TeamController;
use Modules\Users\Http\Controllers\Api\UserAvatarController;
use Modules\Users\Http\Controllers\Api\UserInvitationController;

Route::post('/token', [IssueTokenController::class, 'store'])->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    // Notifications routes
    Route::apiResource('notifications', NotificationController::class)->except(['store', 'update']);
    Route::put('/notifications', [NotificationController::class, 'update']);

    // Personal access tokens routes
    Route::middleware('can:access-api')->group(function () {
        Route::get('/personal-access-tokens', [PersonalAccessTokenController::class, 'index']);
        Route::post('/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);
        Route::delete('/personal-access-tokens/{token}', [PersonalAccessTokenController::class, 'destroy']);
    });

    Route::middleware('admin')->group(function () {
        Route::post('/users/invite', [UserInvitationController::class, 'handle']);

        Route::apiResource('teams', TeamController::class)->except(['show', 'index']);
    });

    Route::apiResource('teams', TeamController::class)->only(['show', 'index']);

    // User profile routes
    Route::get('/me', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'password']);

    // The {user} is not yet used.
    Route::post('/users/{user}/avatar', [UserAvatarController::class, 'store']);
    Route::delete('/users/{user}/avatar', [UserAvatarController::class, 'delete']);
});
