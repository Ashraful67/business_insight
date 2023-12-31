<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Listeners;

use Modules\Contacts\Models\Company;
use Modules\Contacts\Models\Contact;
use Modules\Users\Events\TransferringUserData;

class TransferContactsUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        $this->contacts($event->toUserId, $event->fromUserId);
        $this->companies($event->toUserId, $event->fromUserId);
    }

    /**
     * Transfer contacts.
     */
    public function contacts($toUserId, $fromUserID): void
    {
        Contact::withTrashed()->where('created_by', $fromUserID)->update(['created_by' => $toUserId]);
        Contact::withTrashed()->where('user_id', $fromUserID)->update(['user_id' => $toUserId]);
    }

    /**
     * Transfer companies.
     */
    public function companies($toUserId, $fromUserID): void
    {
        Company::withTrashed()->where('created_by', $fromUserID)->update(['created_by' => $toUserId]);
        Company::withTrashed()->where('user_id', $fromUserID)->update(['user_id' => $toUserId]);
    }
}
