<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Listeners;

use Modules\Contacts\Models\Contact;
use Modules\MailClient\Events\EmailAccountMessageCreated;

class AttachEmailAccountMessageToContact
{
    /**
     * When a message is created, try to associate the message with the actual contact if exists in database
     */
    public function handle(EmailAccountMessageCreated $event): void
    {
        $message = $event->message;

        $emails = array_unique(array_filter([
            $message->from?->address,
            ...$message->to->pluck('address')->all(),
            ...$message->cc->pluck('address')->all(),
            ...$message->bcc->pluck('address')->all(),
        ]));

        if (count($emails) === 0) {
            return;
        }

        $contacts = Contact::whereIn('email', $emails)->get('id');

        foreach ($contacts as $contact) {
            $contact->emails()->syncWithoutDetaching($message->id);
        }
    }
}
