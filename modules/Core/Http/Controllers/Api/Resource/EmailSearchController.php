<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\Resources\HasEmail;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\EmailSearch;
use Modules\Core\Resource\Http\ResourceRequest;

class EmailSearchController extends ApiController
{
    /**
     * Perform email search.
     */
    public function handle(ResourceRequest $request): JsonResponse
    {
        if (empty($request->q)) {
            return $this->response([]);
        }

        $resources = Innoclapps::registeredResources()->whereInstanceOf(HasEmail::class);

        return $this->response(
            new EmailSearch($request, $resources)
        );
    }
}
