<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Macros\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Contracts\Criteria\QueryCriteria as QueryCriteriaContract;

class QueryCriteria
{
    /**
     * Register the macor to the builder instance.
     */
    public static function register(): void
    {
        Builder::macro('criteria', function ($criteria) {
            if ($criteria instanceof QueryCriteriaContract || is_string($criteria)) {
                $criteria = [$criteria];
            }

            if (is_iterable($criteria)) {
                foreach ($criteria as $instance) {
                    if (is_string($instance)) {
                        $instance = new $instance;
                    }

                    $instance->apply($this);
                }
            }

            return $this;
        });
    }
}
