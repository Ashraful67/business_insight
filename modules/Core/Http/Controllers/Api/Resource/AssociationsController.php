<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\Http\ResourceRequest;
use Modules\Core\Timeline\Timelineables;

class AssociationsController extends ApiController
{
    /**
     * Get the resource associations.
     */
    public function __invoke(ResourceRequest $request): JsonResponse
    {
        $this->authorize('view', $request->record());

        $associatedResource = $request->findResource($request->associated);

        abort_if(! $associatedResource?->isAssociateable() || ! $associatedResource->jsonResource(), 404);

        abort_if($request->isForTimeline() &&
            (
                ! Timelineables::hasTimeline($request->record()) ||
                ! Timelineables::isTimelineable($associatedResource->newModel())
            ), 404);

        $method = $request->isForTimeline() ? 'timelineQuery' : 'associatedIndexQuery';

        $records = $associatedResource->{$method}($request->record())
            ->criteria($request->resource()->getRequestCriteria($request))
            ->paginate($request->integer('per_page', null));

        $associatedResource->jsonResource()::topLevelResource($request->record());

        return $this->response(
            $associatedResource->jsonResource()::collection($records)->toResponse($request)->getData()
        );
    }
}
