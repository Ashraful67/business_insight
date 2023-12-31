<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Workflow;

use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Workflow\Workflows;

class WorkflowTriggers extends ApiController
{
    /**
     * Get the available triggers.
     */
    public function __invoke(): JsonResponse
    {
        return $this->response(Workflows::triggersInstance());
    }
}
