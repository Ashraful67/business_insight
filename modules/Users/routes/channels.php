<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('Modules.Users.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
