<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Updater\Exceptions;

use Exception;

class MinPHPVersionRequirementException extends UpdaterException
{
    /**
     * Initialize new LicenseNotActiveException instance
     *
     * @param  string  $message
     * @param  int  $code
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct(
            'Your PHP version does not met the required PHP version for the release you want to update your installation.',
            400,
            $previous
        );
    }
}
