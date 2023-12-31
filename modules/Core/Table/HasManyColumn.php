<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

use Illuminate\Support\Str;
use Modules\Core\Contracts\Countable;

class HasManyColumn extends RelationshipColumn implements Countable
{
    /**
     * HasMany columns are not by default sortable
     */
    public bool $sortable = false;

    /**
     * Indicates whether on the relation count query be performed
     */
    public bool $count = false;

    /**
     * Set that the column should count the results instead of quering all the data
     */
    public function count(): static
    {
        $this->count = true;
        $this->attribute = $this->countKey();

        return $this;
    }

    /**
     * Check whether a column query counts the relation
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
        return Str::snake($this->attribute.'_count');
    }
}
