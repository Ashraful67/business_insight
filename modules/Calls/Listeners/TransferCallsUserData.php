<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Calls\Listeners;

use Modules\Calls\Models\Call;
use Modules\Users\Events\TransferringUserData;

class TransferCallsUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        Call::where('user_id', $event->fromUserId)->update(['user_id' => $event->toUserId]);
    }
}
