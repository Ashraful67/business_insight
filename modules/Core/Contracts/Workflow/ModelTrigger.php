<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Workflow;

interface ModelTrigger
{
    /**
     * The model class name the trigger is related to
     */
    public static function model(): string;
}
