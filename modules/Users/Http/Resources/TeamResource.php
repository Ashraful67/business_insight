<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Http\Resources;

use App\Http\Resources\ProvidesCommonData;
use Illuminate\Http\Request;
use Modules\Core\JsonResource;

/** @mixin \Modules\Users\Models\Team */
class TeamResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'manager' => new UserResource($this->whenLoaded('manager')),
            'members' => UserResource::collection($this->whenLoaded('users')),
        ], $request);
    }
}
