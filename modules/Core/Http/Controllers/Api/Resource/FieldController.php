<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Illuminate\Http\JsonResponse;
use Modules\Core\Facades\Fields;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\Http\ResourceRequest;

class FieldController extends ApiController
{
    /**
     * Get the resource create fields.
     */
    public function create(ResourceRequest $request): JsonResponse
    {
        return $this->response(
            Fields::resolveCreateFieldsForDisplay($request->resourceName())
        );
    }

    /**
     * Get the resource update fields.
     */
    public function update(ResourceRequest $request): JsonResponse
    {
        $request->resource()->setModel($request->record());

        return $this->response(
            Fields::resolveUpdateFieldsForDisplay($request->resourceName())
        );
    }

    /**
     * Get the resource detail fields.
     */
    public function detail(ResourceRequest $request): JsonResponse
    {
        $request->resource()->setModel($request->record());

        return $this->response(
            Fields::resolveDetailFieldsForDisplay($request->resourceName())
        );
    }
}
