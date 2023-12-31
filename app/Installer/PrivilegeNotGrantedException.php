<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Installer;

use Exception;

class PrivilegeNotGrantedException extends Exception
{
    /**
     * Get the privilege name that was denied
     */
    public function getPriviligeName(): string
    {
        $re = '/[0-9]+\s([A-Z]+)+\scommand denied/m';

        preg_match($re, $this->getMessage(), $matches);

        return $matches[1] ?? '';
    }
}
