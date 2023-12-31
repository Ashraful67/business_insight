<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Calendar;

use Modules\Core\AbstractMask;
use Modules\Core\Contracts\Calendar\Calendar as CalendarInterface;

abstract class AbstractCalendar extends AbstractMask implements CalendarInterface
{
    /**
     * jsonSerialize
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * toArray
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'is_default' => $this->isDefault(),
        ];
    }
}
