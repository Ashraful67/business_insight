<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\OAuth;

interface Calendarable
{
    /**
     * Get the OAuth account calendars
     *
     * @return \Modules\Core\Contracts\Calendar\Calendar[]
     */
    public function getCalendars();
}
