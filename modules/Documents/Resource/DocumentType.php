<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Resource;

use Illuminate\Http\Request;
use Modules\Core\Contracts\Resources\Resourceful;
use Modules\Core\Criteria\VisibleModelsCriteria;
use Modules\Core\Fields\ColorSwatches;
use Modules\Core\Fields\Text;
use Modules\Core\Fields\VisibilityGroup;
use Modules\Core\Resource\Resource;
use Modules\Documents\Http\Resources\DocumentTypeResource;
use Modules\Documents\Services\DocumentTypeService;

class DocumentType extends Resource implements Resourceful
{
    /**
     * The column the records should be default ordered by when retrieving
     */
    public static string $orderBy = 'name';

    /**
     * The model the resource is related to
     */
    public static string $model = 'Modules\Documents\Models\DocumentType';

    /**
     * Get the resource service for CRUD operations.
     */
    public function service(): DocumentTypeService
    {
        return new DocumentTypeService();
    }

    /**
     * Provide the criteria that should be used to query only records that the logged-in user is authorized to view
     */
    public function viewAuthorizedRecordsCriteria(): string
    {
        return VisibleModelsCriteria::class;
    }

    /**
     * Get the json resource that should be used for json response
     */
    public function jsonResource(): string
    {
        return DocumentTypeResource::class;
    }

    /**
     * Set the available resource fields
     */
    public function fields(Request $request): array
    {
        return [
            Text::make('name', __('documents::document.type.name'))->rules('required', 'string', 'max:191')->unique(static::$model),
            ColorSwatches::make('swatch_color', __('core::app.colors.color'))->rules('nullable', 'string', 'max:7'),
            VisibilityGroup::make('visibility_group'),
        ];
    }

    /**
     * Get the displayable singular label of the resource
     */
    public static function singularLabel(): string
    {
        return __('documents::document.type.type');
    }

    /**
     * Get the displayable label of the resource
     */
    public static function label(): string
    {
        return __('documents::document.type.types');
    }
}
