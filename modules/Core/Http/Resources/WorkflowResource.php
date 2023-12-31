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

/** @mixin \Modules\Core\Models\Workflow */
class WorkflowResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'total_executions' => $this->total_executions,
            'trigger_type' => $this->trigger_type,
            'action_type' => $this->action_type,
            'data' => $this->data,
        ], $request);
    }
}
