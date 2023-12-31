<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Calendar\Google;

use Modules\Core\Calendar\AbstractCalendar;

class Calendar extends AbstractCalendar
{
    /**
     * Get the calendar ID.
     */
    public function getId(): string
    {
        return $this->getEntity()->getId();
    }

    /**
     * Get the calendar title.
     */
    public function getTitle(): string
    {
        return $this->getEntity()->getSummary();
    }

    /**
     * Check whether the calendar is default.
     */
    public function isDefault(): bool
    {
        return $this->getEntity()->getPrimary() ?: false;
    }
}
