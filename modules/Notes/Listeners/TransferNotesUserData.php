<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Notes\Listeners;

use Modules\Notes\Models\Note;
use Modules\Users\Events\TransferringUserData;

class TransferNotesUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        Note::where('user_id', $event->fromUserId)->update(['user_id' => $event->toUserId]);
    }
}
