<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Services;

use Modules\Core\Contracts\Services\CreateService;
use Modules\Core\Contracts\Services\Service;
use Modules\Core\Contracts\Services\UpdateService;
use Modules\Core\Models\Model;
use Modules\Documents\Models\DocumentType;

class DocumentTypeService implements Service, CreateService, UpdateService
{
    /**
     * Create new type in storage.
     */
    public function create(array $attributes): DocumentType
    {
        $model = DocumentType::create($attributes);

        $model->saveVisibilityGroup($attributes['visibility_group'] ?? []);

        return $model;
    }

    /**
     * Update the given type in storage.
     */
    public function update(Model $model, array $attributes): DocumentType
    {
        $model->fill($attributes)->save();

        if ($attributes['visibility_group'] ?? false) {
            $model->saveVisibilityGroup($attributes['visibility_group']);
        }

        return $model;
    }
}
