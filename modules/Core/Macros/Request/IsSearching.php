<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Macros\Request;

class IsSearching
{
    /**
     * Determine whether user is performing search via the RequestCriteria
     *
     * @return bool
     */
    public function __invoke()
    {
        return ! is_null(request()->get('q', null));
    }
}
