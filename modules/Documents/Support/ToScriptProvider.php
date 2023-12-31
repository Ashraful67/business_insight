<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Support;

use Illuminate\Support\Facades\Auth;
use Modules\Documents\Content\DocumentContent;
use Modules\Documents\Enums\DocumentStatus;
use Modules\Documents\Http\Resources\DocumentTypeResource;
use Modules\Documents\Models\Document;
use Modules\Documents\Models\DocumentType;

class ToScriptProvider
{
    /**
     * Provide the data to script.
     */
    public function __invoke(): array
    {
        if (! Auth::check()) {
            return [];
        }

        return ['documents' => [
            'default_document_type' => DocumentType::getDefaultType(),

            'navigation_heading_tag_name' => DocumentContent::NAVIGATION_HEADING_TAG_NAME,

            'placeholders' => (new Document)->placeholders(),

            'statuses' => collect(DocumentStatus::cases())->mapWithKeys(
                fn ($case) => [$case->value => ['name' => $case->value, 'icon' => $case->icon(), 'color' => $case->color()]]
            ),

            'types' => DocumentTypeResource::collection(
                DocumentType::withCommon()
                    ->withVisibilityGroups()
                    ->visible()
                    ->orderBy('name')
                    ->get()
            ),
        ]];
    }
}
