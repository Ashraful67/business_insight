<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Resource;

use Illuminate\Http\Request;
use Modules\Contacts\Http\Resources\IndustryResource;
use Modules\Core\Contracts\Resources\Resourceful;
use Modules\Core\Fields\Text;
use Modules\Core\Resource\Resource;

class Industry extends Resource implements Resourceful
{
    /**
     * The column the records should be default ordered by when retrieving
     */
    public static string $orderBy = 'name';

    /**
     * The model the resource is related to
     */
    public static string $model = 'Modules\Contacts\Models\Industry';

    /**
     * Set the available resource fields
     */
    public function fields(Request $request): array
    {
        return [
            Text::make('name', __('contacts::company.industry.industry'))->rules('required', 'string', 'max:191')->unique(static::$model),
        ];
    }

    /**
     * Get the displayable singular label of the resource
     */
    public static function singularLabel(): string
    {
        return __('contacts::company.industry.industry');
    }

    /**
     * Get the displayable label of the resource
     */
    public static function label(): string
    {
        return __('contacts::company.industry.industries');
    }

    /**
     * Get the json resource that should be used for json response
     */
    public function jsonResource(): string
    {
        return IndustryResource::class;
    }
}
