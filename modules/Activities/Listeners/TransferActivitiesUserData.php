<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Listeners;

use Modules\Activities\Models\Activity;
use Modules\Users\Events\TransferringUserData;

class TransferActivitiesUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        Activity::withTrashed()->where('created_by', $event->fromUserId)->update(['created_by' => $event->toUserId]);
        Activity::withTrashed()->where('user_id', $event->fromUserId)->update(['user_id' => $event->toUserId]);
    }
}
