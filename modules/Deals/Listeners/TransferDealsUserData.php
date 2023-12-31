<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Listeners;

use Modules\Deals\Models\Deal;
use Modules\Users\Events\TransferringUserData;

class TransferDealsUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        Deal::withTrashed()->where('created_by', $event->fromUserId)->update(['created_by' => $event->toUserId]);
        Deal::withTrashed()->where('user_id', $event->fromUserId)->update(['user_id' => $event->toUserId]);
    }
}
