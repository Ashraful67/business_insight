<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Resources;

interface HasEmail
{
    /**
     * Get the resource model email address field name.
     */
    public function emailAddressField(): string;
}
