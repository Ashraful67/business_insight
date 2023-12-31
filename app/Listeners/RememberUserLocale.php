<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Listeners;

class RememberUserLocale
{
    /**
     * Remembers  the user default locale in session after the user is logged in.
     *
     * This helps to persist the locale even after the user is logged out
     * In the login page will show the correct locale
     */
    public function handle(object $event): void
    {
        session()->put('locale', $event->user->preferredLocale());
    }
}
