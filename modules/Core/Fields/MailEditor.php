<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

class MailEditor extends Field
{
    /**
     * Field component
     */
    public ?string $component = 'mail-editor-field';

    /**
     * Resolve the field value
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return string
     */
    public function resolve($model)
    {
        return clean(parent::resolve($model));
    }
}
