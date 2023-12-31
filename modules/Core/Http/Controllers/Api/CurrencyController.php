<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\ApiController;

class CurrencyController extends ApiController
{
    /**
     * Get the application available currencies.
     */
    public function __invoke(): JsonResponse
    {
        return $this->response(config('money'));
    }
}
