<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

trait ChangesKeys
{
    /**
     * From where the value key should be taken
     */
    public string $valueKey = 'value';

    /**
     * From where the label key should be taken
     */
    public string $labelKey = 'label';

    /**
     * Set custom key for value
     *
     *
     * @return mixed
     */
    public function valueKey(string $key): static
    {
        $this->valueKey = $key;

        return $this;
    }

    /**
     * Set custom label key
     *
     *
     * @return mixed
     */
    public function labelKey(string $key): static
    {
        $this->labelKey = $key;

        return $this;
    }
}
