<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Fields;

use Modules\Activities\Http\Resources\GuestResource;
use Modules\Core\Fields\Field;

class GuestsSelect extends Field
{
    /**
     * Field component
     */
    public ?string $component = 'guests-select-field';

    /**
     * Custom boot function
     *
     * @return void
     */
    public function boot()
    {
        $this->provideSampleValueUsing(fn () => []);
    }

    /**
     * Resolve the displayable field value (for mail placeholders)
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return string|null
     */
    public function resolveForDisplay($model)
    {
        $value = parent::resolveForDisplay($model);

        if ($value->isNotEmpty()) {
            $value->loadMissing('guestable');

            return $value->map(fn ($guest) => $guest->guestable)->map->getGuestDisplayName()->implode(', ');
        }

        return null;
    }

    /**
     * Resolve the field value for JSON Resource
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array|null
     */
    public function resolveForJsonResource($model)
    {
        if ($model->relationLoaded('guests')) {
            return ['guests' => GuestResource::collection($model->guests)];
        }

        return null;
    }
}
