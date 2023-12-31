<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

use Illuminate\Pagination\LengthAwarePaginator as BaseLengthAwarePaginator;

class LengthAwarePaginator extends BaseLengthAwarePaginator
{
    protected array $merge = [];

    /**
     * Set the all time total
     */
    public function setAllTimeTotal(int $total): static
    {
        return $this->merge(['all_time_total' => $total]);
    }

    /**
     * Add additional data to be merged with the response
     */
    public function merge(array $data): static
    {
        $this->merge = array_merge($this->merge, $data);

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), $this->merge);
    }
}
