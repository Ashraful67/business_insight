<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Core\Facades\Cards;
use Modules\Core\Http\Controllers\ApiController;

class CardController extends ApiController
{
    /**
     * Get cards that are intended to be shown on dashboards.
     */
    public function forDashboards(): JsonResponse
    {
        return $this->response(Cards::resolveForDashboard());
    }

    /**
     * Get the available cards for a given resource.
     */
    public function index(string $resourceName): JsonResponse
    {
        return $this->response(Cards::resolve($resourceName));
    }

    /**
     * Get card by given uri key.
     */
    public function show(string $card): JsonResponse
    {
        return $this->response(Cards::registered()->first(function ($item) use ($card) {
            return $item->uriKey() === $card;
        })->authorizeOrFail());
    }
}
