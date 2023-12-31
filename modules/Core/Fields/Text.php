<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Modules\Core\Contracts\Fields\Customfieldable;
use Modules\Core\Contracts\Fields\CustomfieldUniqueable;

class Text extends Field implements Customfieldable, CustomfieldUniqueable
{
    use ChecksForDuplicates;

    /**
     * This field support input group
     */
    public bool $supportsInputGroup = true;

    /**
     * Input type
     */
    public string $inputType = 'text';

    /**
     * Field component
     */
    public ?string $component = 'text-field';

    /**
     * Specify type attribute for the text field
     */
    public function inputType(string $type): static
    {
        $this->inputType = $type;

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
        $table->string($fieldId)->nullable();
    }

    /**
     * jsonSerialize
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'inputType' => $this->inputType,
        ]);
    }
}
