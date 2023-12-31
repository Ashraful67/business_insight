<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Workflow;

interface FieldChangeTrigger
{
    /**
     * The field to track changes on
     */
    public static function field(): string;

    /**
     * Provide the change field
     *
     * @return \Modules\Core\Fields\Field
     */
    public static function changeField();
}
