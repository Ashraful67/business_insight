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

/** @mixin \Modules\Core\Models\Filter */
class FilterResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'name' => $this->name,
            'identifier' => $this->identifier,
            'rules' => $this->rules,
            'user_id' => $this->user_id,
            'is_shared' => $this->is_shared,
            'is_system_default' => $this->is_system_default,
            'is_readonly' => $this->is_readonly,
            'defaults' => $this->defaults->map(function ($default) {
                return [
                    'user_id' => $default->user_id,
                    'view' => $default->view,
                ];
            })->values(),
        ], $request);
    }
}
