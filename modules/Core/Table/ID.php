<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

class ID extends Column
{
    /**
     * Initialize new ID instance.
     */
    public function __construct(?string $label = null, ?string $attribute = 'id')
    {
        parent::__construct($attribute, $label);

        $this->minWidth('120px')->width('120px');
    }
}
