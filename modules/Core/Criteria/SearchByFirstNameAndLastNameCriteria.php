<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Contracts\Criteria\QueryCriteria;

class SearchByFirstNameAndLastNameCriteria implements QueryCriteria
{
    /**
     * Apply the criteria for the given query.
     */
    public function apply(Builder $query)
    {
        $search = request('q');

        if ($raw = $query->getModel()->nameQueryExpression()) {
            $query->where($raw, 'LIKE', "%$search%");
        }
    }
}
