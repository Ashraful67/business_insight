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

class BelongsToManyColumn extends RelationshipColumn implements Countable
{
    /**
     * BelongsToMany column is not sortable by default
     */
    public bool $sortable = false;

    /**
     * Indicates whether on the relation count query be performed
     */
    public bool $count = false;

    /**
     * Data heading component
     */
    public string $component = 'table-data-option-column';

    /**
     * Set that the column should count the results instead of quering all the data
     */
    public function count(): static
    {
        $this->count = true;
        $this->attribute = $this->countKey();
        $this->useComponent('table-data-column');

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
