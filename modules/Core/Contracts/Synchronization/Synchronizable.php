<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Synchronization;

use Modules\Core\Models\Synchronization;

interface Synchronizable
{
    /**
     * Synchronize the data for the given synchronization
     */
    public function synchronize(Synchronization $synchronization): void;
}
