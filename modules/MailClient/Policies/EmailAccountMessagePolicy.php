<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\MailClient\Models\EmailAccountMessage;
use Modules\Users\Models\User;

class EmailAccountMessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the message.
     *
     * Used for message sync associations
     */
    public function update(User $user, EmailAccountMessage $message): bool
    {
        if ($message->account->isPersonal()) {
            return (int) $user->id === (int) $message->account->user_id;
        }

        if ($user->can('access shared inbox')) {
            return true;
        }

        return false;
    }
}
