<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

class Reminder extends Field
{
    /**
     * Field component
     */
    public ?string $component = 'reminder-field';

    /**
     * Indicates whether to allow the user to cancel the reminder
     */
    public function cancelable(): static
    {
        $this->rules('nullable');

        return $this->withMeta([__FUNCTION__ => true]);
    }
}
