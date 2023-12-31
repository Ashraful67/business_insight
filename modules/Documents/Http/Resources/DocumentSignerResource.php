<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Modules\Documents\Models\DocumentSigner */
class DocumentSignerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'sent_at' => $this->sent_at,
            'send_email' => $this->send_email,
            'signed_at' => $this->signed_at,
            'signature' => $this->signature,
            'sign_ip' => $this->sign_ip,
        ];
    }
}
