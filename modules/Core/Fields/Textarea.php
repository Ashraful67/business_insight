<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Modules\Core\Contracts\Fields\Customfieldable;

class Textarea extends Field implements Customfieldable
{
    /**
     * Field component
     */
    public ?string $component = 'textarea-field';

    /**
     * Textarea rows attribute
     */
    public function rows(string|int $rows): static
    {
        $this->withMeta(['attributes' => ['rows' => $rows]]);

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
        $table->text($fieldId)->nullable();
    }
}
