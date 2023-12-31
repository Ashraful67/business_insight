<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Illuminate\Http\JsonResponse;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\GlobalSearch;
use Modules\Core\Resource\Http\ResourceRequest;

class GlobalSearchController extends ApiController
{
    /**
     * Perform global search.
     */
    public function handle(ResourceRequest $request): JsonResponse
    {
        if (empty($request->q)) {
            return $this->response([]);
        }

        $resources = Innoclapps::globallySearchableResources();

        return $this->response(
            new GlobalSearch($request, $resources)
        );
    }
}
