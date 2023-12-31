<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Listeners;

use Modules\MailClient\Models\EmailAccount;
use Modules\MailClient\Models\PredefinedMailTemplate;
use Modules\Users\Events\TransferringUserData;

class TransferMailClientUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        $this->emailAccounts($event->toUserId, $event->fromUserId);
        $this->predefinedMailTemplates($event->toUserId, $event->fromUserId);
    }

    /**
     * Transfer accounts created by.
     *
     * Personal accounts are deleted, here only shared are transfered.
     */
    public function emailAccounts($toUserId, $fromUserId): void
    {
        EmailAccount::where('created_by', $fromUserId)->update(['created_by' => $toUserId]);
    }

    /**
     * Transfer shared predefined mail templates.
     */
    public function predefinedMailTemplates($toUserId, $fromUserId): void
    {
        PredefinedMailTemplate::where('user_id', $fromUserId)
            ->where('is_shared', true)
            ->update(['user_id' => $toUserId]);
    }
}
