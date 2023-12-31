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

/** @mixin \Modules\Core\Models\MailableTemplate */
class MailableResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return $this->withCommonData([
            'name' => $this->name,
            'locale' => $this->locale,
            'subject' => $this->getSubject(),
            'html_template' => clean($this->getHtmlTemplate()),
            'text_template' => clean($this->getTextTemplate()),
            'placeholders' => $this->getPlaceholders(),
        ], $request);
    }
}
