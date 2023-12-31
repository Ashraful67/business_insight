<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Zapier;

use Exception;

class ActionNotSupportedException extends Exception
{
    /**
     * Initialize ActionNotSupportedException
     */
    public function __construct($action, $code = 0, Exception $previous = null)
    {
        parent::__construct("$action is not supported.", $code, $previous);
    }
}
