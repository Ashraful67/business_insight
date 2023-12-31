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

class SearchController extends ApiController
{
    /**
     * Perform search for a resource.
     */
    public function handle(ResourceRequest $request): JsonResponse
    {
        $resource = tap($request->resource(), function ($resource) {
            abort_if(! $resource::searchable(), 404);
        });

        if (empty($request->q)) {
            return $this->response([]);
        }

        $query = $resource->searchQuery()
            ->criteria($resource->getRequestCriteria($request));

        if ($criteria = $resource->viewAuthorizedRecordsCriteria()) {
            $query->criteria($criteria);
        }

        return $this->response(
            $request->toResponse(
                $resource->order($query)->get()
            )
        );
    }
}
