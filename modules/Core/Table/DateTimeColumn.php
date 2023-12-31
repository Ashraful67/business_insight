<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

use Modules\Core\Facades\Format;

class DateTimeColumn extends Column
{
    /**
     * Initialize new DateTimeColumn instance.
     */
    public function __construct(?string $attribute = null, ?string $label = null)
    {
        parent::__construct($attribute, $label);

        $this->displayAs(fn ($model) => Format::dateTime($model->{$this->attribute}));
    }
}
