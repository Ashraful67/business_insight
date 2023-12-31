<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Filters;

class MultiSelect extends Select
{
    /**
     * Defines a filter type
     */
    public function type(): string
    {
        return 'multi-select';
    }
}
