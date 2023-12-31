<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Macros\Request;

class IsZapier
{
    /**
     * Determine whether current request is from Zapier
     *
     * @return bool
     */
    public function __invoke()
    {
        return request()->header('user-agent') === 'Zapier';
    }
}
