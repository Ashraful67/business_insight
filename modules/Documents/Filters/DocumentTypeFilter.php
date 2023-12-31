<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Filters;

use Modules\Core\Filters\MultiSelect;
use Modules\Documents\Models\DocumentType;

class DocumentTypeFilter extends MultiSelect
{
    /**
     * Create new DocumentTypeFilter instance
     */
    public function __construct()
    {
        parent::__construct('document_type_id', __('documents::fields.documents.type.name'));

        $this->labelKey('name')
            ->valueKey('id')
            ->options(
                fn () => DocumentType::select(['id', 'name'])
                    ->visible()
                    ->orderBy('name')
                    ->get()
            );
    }
}
