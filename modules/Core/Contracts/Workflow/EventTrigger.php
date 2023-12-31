<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Workflow;

interface EventTrigger
{
    /**
     * The event name the trigger should be triggered
     */
    public static function event(): string;
}
