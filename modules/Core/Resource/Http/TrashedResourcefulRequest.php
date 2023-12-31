<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Resource\Http;

use Illuminate\Database\Eloquent\Builder;

class TrashedResourcefulRequest extends ResourcefulRequest
{
    /**
     * Get new query for the current resource.
     */
    public function newQuery(): Builder
    {
        return $this->resource()->newQuery()->onlyTrashed();
    }
}
