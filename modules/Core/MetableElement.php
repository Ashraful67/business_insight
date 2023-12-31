<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

trait MetableElement
{
    /**
     * Additional field meta
     */
    public array $meta = [];

    /**
     * Get the element meta
     */
    public function meta(): array
    {
        return $this->meta;
    }

    /**
     * Add element meta
     */
    public function withMeta(array $attributes): static
    {
        $this->meta = array_merge_recursive($this->meta, $attributes);

        return $this;
    }
}
