<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

use Modules\Core\Facades\Format;

class DateColumn extends Column
{
    /**
     * Initialize new DateColumn instance.
     */
    public function __construct(?string $attribute = null, ?string $label = null)
    {
        parent::__construct($attribute, $label);

        $this->displayAs(fn ($model) => Format::date($model->{$this->attribute}));
    }
}
