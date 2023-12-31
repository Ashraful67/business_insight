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

class FilterRulesController extends ApiController
{
    /**
     * Get the resource available filters rules.
     */
    public function index(ResourceRequest $request): JsonResponse
    {
        return $this->response($request->resource()->filtersForResource($request));
    }
}
