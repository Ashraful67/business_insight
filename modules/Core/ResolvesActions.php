<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

use Illuminate\Support\Collection;
use Modules\Core\Resource\Http\ResourceRequest;

trait ResolvesActions
{
    /**
     * Get the available actions for the resource
     */
    public function resolveActions(ResourceRequest $request): Collection
    {
        $actions = $this->actions($request);

        $collection = is_array($actions) ? new Collection($actions) : $actions;

        return $collection->filter->authorizedToSee()->values();
    }

    /**
     * @codeCoverageIgnore
     *
     * Get the defined resource actions
     */
    public function actions(ResourceRequest $request): array|Collection
    {
        return [];
    }
}
