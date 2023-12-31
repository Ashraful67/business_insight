<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Listeners;

use Modules\Billable\Models\Product;
use Modules\Users\Events\TransferringUserData;

class TransferProductsUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        Product::withTrashed()->where('created_by', $event->fromUserId)->update(['created_by' => $event->toUserId]);
    }
}
