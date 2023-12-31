<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Calendar;

interface Calendar
{
    /**
     * Get the calendar ID.
     */
    public function getId(): int|string;

    /**
     * Get the calendar title.
     */
    public function getTitle(): string;

    /**
     * Check whether the calendar is default.
     */
    public function isDefault(): bool;
}
