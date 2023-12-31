<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Illuminate\Support\Collection;

class FieldsCollection extends Collection
{
    /**
     * Find field by attribute
     *
     * @param  string  $attribute
     * @return \Modules\Core\Fields\Field|null
     */
    public function find($attribute)
    {
        return $this->firstWhere('attribute', $attribute);
    }

    /**
     * Find field by request attribute
     *
     * @param  string  $attribute
     * @return \Modules\Core\Fields\Field|null
     */
    public function findByRequestAttribute($attribute)
    {
        return $this->first(function ($field) use ($attribute) {
            return $field->requestAttribute() === $attribute;
        });
    }
}
