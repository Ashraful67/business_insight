<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Modules\Core\Contracts\Fields\Customfieldable;

class Radio extends Optionable implements Customfieldable
{
    /**
     * Field component
     */
    public ?string $component = 'radio-field';

    /**
     * Indicates that the radio field will be inline
     */
    public function inline(): static
    {
        $this->withMeta(['inline' => true]);

        return $this;
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
        $table->unsignedBigInteger($fieldId)->nullable();
        $table->foreign($fieldId)
            ->references('id')
            ->on('custom_field_options');
    }
}
