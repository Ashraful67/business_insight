<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Illuminate\Support\Str;

trait CountsRelationship
{
    /**
     * Indicates whether the relation will be counted
     */
    public bool $count = false;

    /**
     * Indicates that the relation will be counted
     */
    public function count(): static
    {
        $this->count = true;
        $this->attribute = Str::snake($this->attribute).'_count';

        return $this;
    }

    /**
     * Check whether the field counts the relation
     */
    public function counts(): bool
    {
        return $this->count === true;
    }

    /**
     * Get the count key
     */
    public function countKey(): string
    {
        return $this->attribute;
    }
}
