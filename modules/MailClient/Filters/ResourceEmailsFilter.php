<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Filters;

use Modules\Core\Filters\HasMany;
use Modules\Core\Filters\Number;
use Modules\Core\Filters\Operand;

class ResourceEmailsFilter extends HasMany
{
    /**
     * Initialize ResourceEmailsFilter class
     */
    public function __construct()
    {
        parent::__construct('emails', __('mailclient::mail.emails'));

        $this->setOperands([
            Operand::make('total_unread', __('mailclient::inbox.unread_count'))->filter(
                Number::make('total_unread')->countableRelation('unreadEmailsForUser')
            ),
        ]);
    }
}
