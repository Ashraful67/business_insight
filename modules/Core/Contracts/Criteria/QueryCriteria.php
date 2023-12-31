<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Criteria;

use Illuminate\Database\Eloquent\Builder;

interface QueryCriteria
{
    /**
     * Apply the criteria for the given query.
     */
    public function apply(Builder $builder);
}
