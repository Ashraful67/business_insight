<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Modules\Deals\Models\Stage */
class DealBoardResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'win_probability' => $this->win_probability,
            'display_order' => $this->display_order,
            'summary' => $this->summary,
            'cards' => DealBoardCardResource::collection($this->deals),
        ];
    }
}
