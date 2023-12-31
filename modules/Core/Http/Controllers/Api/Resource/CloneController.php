<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\Resources\Cloneable;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\Http\ResourceRequest;

class CloneController extends ApiController
{
    /**
     * Clone a resource record
     */
    public function handle(ResourceRequest $request): JsonResponse
    {
        /** @var \Modules\Core\Resource\Resource&\Modules\Core\Contracts\Resources\Cloneable */
        $resource = $request->resource();

        abort_unless($resource instanceof Cloneable, 404);

        $this->authorize('view', $request->record());

        $record = $resource->clone($request->record(), $request->user()->id);

        return $this->response($request->toResponse(
            $resource->displayQuery()->find($record->getKey())
        ));
    }
}
