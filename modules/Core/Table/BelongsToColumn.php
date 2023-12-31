<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

class BelongsToColumn extends RelationshipColumn
{
    /**
     * @var callable|null
     */
    public $orderColumnCallback;

    /**
     * Add custom order column name callback
     */
    public function orderByColumn(callable $callback): static
    {
        $this->orderColumnCallback = $callback;

        return $this;
    }
}
