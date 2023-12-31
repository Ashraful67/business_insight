<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Events;

use Illuminate\Queue\SerializesModels;
use Modules\MailClient\Client\Contracts\MessageInterface;
use Modules\MailClient\Models\EmailAccountMessage;

class EmailAccountMessageCreated
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public EmailAccountMessage $message, public MessageInterface $remoteMessage)
    {
    }
}
