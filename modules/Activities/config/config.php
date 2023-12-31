<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

return [
    'name' => 'Activities',

    /*
    |--------------------------------------------------------------------------
    | Application defaults config
    |--------------------------------------------------------------------------
    | Here you can specify defaults configurations that the application
    | uses when configuring specific option e.q. creating a follow up task
    | automatically uses the configured hour and minutes.
    |
    */
    'defaults' => [
        'hour' => env('PREFERRED_DEFAULT_HOUR', 8),
        'minutes' => env('PREFERRED_DEFAULT_MINUTES', 0),
        'reminder_minutes' => env('PREFERRED_DEFAULT_REMINDER_MINUTES', 30),
    ],
];
