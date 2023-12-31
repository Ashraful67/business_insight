<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Updater\Exceptions;

use Exception;

class PurchaseKeyEmptyException extends UpdaterException
{
    /**
     * Initialize new PurchaseKeyEmptyException instance
     *
     * @param  string  $message
     * @param  int  $code
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct('Purchase key not provided [empty].', 400, $previous);
    }
}
