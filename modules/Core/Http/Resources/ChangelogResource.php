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
use Illuminate\Support\Str;
use Modules\Core\JsonResource;

/** @mixin \Modules\Core\Models\Changelog */
class ChangelogResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'description' => $this->description,
            'causer_name' => $this->causer_name,
            'properties' => $this->properties,
            'module' => str_starts_with($this->subject_type, config('modules.namespace')) ?
                strtolower(Str::of($this->subject_type)->explode('\\')[1]) :
                null,
        ], $request);
    }
}
