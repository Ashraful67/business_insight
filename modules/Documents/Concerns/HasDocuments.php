<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Deals\Criteria\ViewAuthorizedDealsCriteria;
use Modules\Documents\Enums\DocumentStatus;

/** @mixin \Modules\Core\Models\Model */
trait HasDocuments
{
    /**
     * Get all of the associated documents for the contact.
     */
    public function documents(): MorphToMany
    {
        return $this->morphToMany(\Modules\Documents\Models\Document::class, 'documentable');
    }

    /**
     * Get the documents the user is authorized to see
     */
    public function documentsForUser(): MorphToMany
    {
        return $this->documents()->criteria(ViewAuthorizedDealsCriteria::class);
    }

    /**
     * Get the draft documents the user is authorized to see
     */
    public function draftDocumentsForUser(): MorphToMany
    {
        return $this->documentsForUser()->where('status', DocumentStatus::DRAFT);
    }
}
