<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

return [
    'name' => 'Users',
    /*
    |--------------------------------------------------------------------------
    | User invitation config
    |--------------------------------------------------------------------------
    |
    */
    'invitation' => [
        'expires_after' => env('USER_INVITATION_EXPIRES_AFTER', 3), // in days
    ],
];
