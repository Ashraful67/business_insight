<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Comments\Http\Resources;

use App\Http\Resources\ProvidesCommonData;
use Illuminate\Http\Request;
use Modules\Core\JsonResource;
use Modules\Users\Http\Resources\UserResource;

/** @mixin \Modules\Comments\Models\Comment */
class CommentResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'body' => clean($this->body),
            'sentiment'=>$this->sentiment,
            'created_by' => $this->created_by,
            'creator' => new UserResource($this->whenLoaded('creator')),
        ], $request);
    }
}
