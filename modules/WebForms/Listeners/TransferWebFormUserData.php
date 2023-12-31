<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\WebForms\Listeners;

use Modules\Users\Events\TransferringUserData;
use Modules\WebForms\Models\WebForm;

class TransferWebFormUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        WebForm::where('created_by', $event->fromUserId)->update(['created_by' => $event->toUserId]);
        WebForm::where('user_id', $event->fromUserId)->update(['user_id' => $event->toUserId]);
    }
}
