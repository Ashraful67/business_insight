<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Activities\Http\Resources\ActivityResource;
use Modules\Activities\Models\Activity;
use Modules\Core\Http\Controllers\ApiController;

class ActivityStateController extends ApiController
{
    /**
     * Mark activity as complete.
     */
    public function complete(Activity $activity): JsonResponse
    {
        $this->authorize('changeState', $activity);

        $activity->markAsComplete();

        return $this->response(
            new ActivityResource($activity->resource()->displayQuery()->find($activity->id))
        );
    }

    /**
     * Mark activity as incomplete.
     */
    public function incomplete(Activity $activity): JsonResponse
    {
        $this->authorize('changeState', $activity);

        $activity->markAsIncomplete();

        return $this->response(
            new ActivityResource($activity->resource()->displayQuery()->find($activity->id))
        );
    }
}
