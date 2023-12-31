<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Core\Facades\Permissions;
use Modules\Core\Http\Controllers\ApiController;

class PermissionController extends ApiController
{
    /**
     * Get all registered application permissions.
     */
    public function index(): JsonResponse
    {
        Permissions::createMissing();

        return $this->response([
            'grouped' => Permissions::groups(),
            'all' => Permissions::all(),
        ]);
    }
}
