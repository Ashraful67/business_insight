<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Http\Resources;

use App\Http\Resources\ProvidesCommonData;
use Illuminate\Http\Request;
use Modules\Core\JsonResource;
use Modules\Users\Http\Resources\UserResource;

/** @mixin \Modules\MailClient\Models\PredefinedMailTemplate */
class PredefinedMailTemplateResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'name' => $this->name,
            'subject' => $this->subject,
            'body' => $this->body,
            'is_shared' => $this->is_shared,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
        ], $request);
    }
}
