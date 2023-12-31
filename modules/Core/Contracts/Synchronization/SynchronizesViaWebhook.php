<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Synchronization;

use Modules\Core\Models\Synchronization;

interface SynchronizesViaWebhook
{
    /**
     * Subscribe for changes for the given synchronization
     */
    public function watch(Synchronization $synchronization): void;

    /**
     * Unsubscribe from changes for the given synchronization
     */
    public function unwatch(Synchronization $synchronization): void;
}
