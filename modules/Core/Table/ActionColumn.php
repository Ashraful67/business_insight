<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Table;

class ActionColumn extends Column
{
    /**
     * This column is not sortable
     */
    public bool $sortable = false;

    /**
     * Initialize new ActionColumn instance.
     */
    public function __construct(?string $label = null)
    {
        // Set the attribute to null to prevent showing on re-order table options
        parent::__construct(null, $label);

        $this->width('150px');
    }
}
