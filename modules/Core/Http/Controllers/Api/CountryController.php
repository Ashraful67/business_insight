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
use Modules\Core\Http\Resources\CountryResource;
use Modules\Core\Models\Country;

class CountryController extends ApiController
{
    /**
     * Get a list of all the application countries in storage.
     */
    public function handle(): JsonResponse
    {
        return $this->response(
            CountryResource::collection(Country::get())
        );
    }
}
