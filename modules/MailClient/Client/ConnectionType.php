<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Client;

enum ConnectionType: string
{
    case Gmail = 'Gmail';
    case Outlook = 'Outlook';
    case Imap = 'Imap';
}
