<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Http\Resources;

use Illuminate\Http\Request;
use Modules\Core\Resource\Http\JsonResource;

/** @mixin \Modules\Documents\Models\DocumentTemplate */
class DocumentTemplateResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Modules\Core\Resource\Http\ResourceRequest  $request
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => clean($this->content),
            'view_type' => $this->view_type,
            'is_shared' => $this->is_shared,
            'user_id' => $this->user_id,
            'google_fonts' => $this->usedGoogleFonts(),
        ];
    }
}
