<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Billable\Criteria\ViewAuthorizedProductsCriteria;
use Modules\Billable\Http\Resources\ProductResource;
use Modules\Billable\Models\Product;
use Modules\Core\Criteria\RequestCriteria;
use Modules\Core\Http\Controllers\ApiController;

class ActiveProductController extends ApiController
{
    /**
     * Search for active products
     */
    public function handle(): JsonResponse
    {
        $products = Product::criteria(RequestCriteria::class)
            ->criteria(ViewAuthorizedProductsCriteria::class)
            ->active()
            ->get();

        return $this->response(ProductResource::collection($products));
    }
}
