<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Resources;

use App\Http\Resources\ProvidesCommonData;
use Illuminate\Http\Request;
use Modules\Core\JsonResource;

/** @mixin \Modules\Core\Models\CustomField */
class CustomFieldResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'field_type' => $this->field_type,
            'resource_name' => $this->resource_name,
            'field_id' => $this->field_id,
            'label' => $this->label,
            'options' => $this->when($this->options->isNotEmpty(), $this->options),
            'is_unique' => $this->is_unique,
        ], $request);
    }
}
