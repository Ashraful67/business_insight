<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Concerns;

use Illuminate\Database\Eloquent\Prunable as LaravelPrunable;

/** @mixin \Modules\Core\Models\Model */
trait Prunable
{
    use LaravelPrunable;

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('deleted_at', '<=', now()->subDays(
            config('core.soft_deletes.prune_after')
        ));
    }
}
