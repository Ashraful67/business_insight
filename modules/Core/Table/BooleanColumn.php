<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

class BooleanColumn extends Column
{
    /**
     * Initialize new BooleanColumn instance.
     */
    public function __construct(?string $attribute = null, ?string $label = null)
    {
        parent::__construct($attribute, $label);

        $this->centered();
    }

    /**
     * Checkbox checked value
     */
    public mixed $trueValue = true;

    /**
     * Checkbox unchecked value
     */
    public mixed $falseValue = false;

    /**
     * Data heading component
     */
    public string $component = 'table-data-boolean-column';

    /**
     * Checkbox checked value
     */
    public function trueValue(mixed $val): static
    {
        $this->trueValue = $val;

        return $this;
    }

    /**
     * Checkbox unchecked value
     */
    public function falseValue(mixed $val): static
    {
        $this->falseValue = $val;

        return $this;
    }

    /**
     * Additional column meta
     */
    public function meta(): array
    {
        return array_merge([
            'falseValue' => $this->falseValue,
            'trueValue' => $this->trueValue,
        ], $this->meta);
    }
}
