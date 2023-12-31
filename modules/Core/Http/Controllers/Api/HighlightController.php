<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Core\Highlights\Highlights;
use Modules\Core\Http\Controllers\ApiController;

class HighlightController extends ApiController
{
    /**
     * Get the application highlights.
     */
    public function __invoke(): JsonResponse
    {
        return $this->response(Highlights::get());
    }
}
