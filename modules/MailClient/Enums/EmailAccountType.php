<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Enums;

enum EmailAccountType: string
{
    case PERSONAL = 'personal';
    case SHARED = 'shared';
}
