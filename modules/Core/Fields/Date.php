<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Modules\Core\Contracts\Fields\Customfieldable;
use Modules\Core\Contracts\Fields\Dateable;
use Modules\Core\Facades\Format;
use Modules\Core\Fields\Dateable as DateableTrait;
use Modules\Core\Placeholders\DatePlaceholder;
use Modules\Core\Table\DateColumn;

class Date extends Field implements Customfieldable, Dateable
{
    use DateableTrait;

    /**
     * Field component
     */
    public ?string $component = 'date-field';

    /**
     * Boot the field
     *
     * @return void
     */
    public function boot()
    {
        $this->rules(['nullable', 'date'])
            ->provideSampleValueUsing(fn () => date('Y-m-d'));
    }

    /**
     * Create the custom field value column in database
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $table
     * @param  string  $fieldId
     * @return void
     */
    public static function createValueColumn($table, $fieldId)
    {
        $table->date($fieldId)->nullable();
    }

    /**
     * Resolve the displayable field value
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return string|null
     */
    public function resolveForDisplay($model)
    {
        return Format::date($model->{$this->attribute});
    }

    /**
     * Get the mailable template placeholder
     *
     * @param  \Modules\Core\Models\Model|null  $model
     * @return \Modules\Core\Placeholders\DatePlaceholder
     */
    public function mailableTemplatePlaceholder($model)
    {
        return DatePlaceholder::make($this->attribute)
            ->value(fn () => $this->resolve($model))
            ->forUser($model?->user)
            ->description($this->label);
    }

    /**
     * Provide the column used for index
     */
    public function indexColumn(): DateColumn
    {
        return new DateColumn($this->attribute, $this->label);
    }
}
