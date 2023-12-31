<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Http\Resources;

use App\Http\Resources\ProvidesCommonData;
use Illuminate\Http\Request;
use Modules\Core\JsonResource;

/** @mixin \Modules\Billable\Models\Billable */
class BillableResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'tax_type' => $this->tax_type->name,
            'sub_total' => $this->sub_total,
            'has_discount' => $this->has_discount,
            'total_discount' => $this->total_discount,
            'total_tax' => $this->total_tax,
            'applied_taxes' => $this->getAppliedTaxes(),
            'total' => $this->total,
            // 'terms'    => $this->terms,
            // 'notes'    => $this->notes,
            'products' => $this->relationLoaded('products') ?
                BillableProductResource::collection($this->products) :
                [],
        ], $request);
    }
}
