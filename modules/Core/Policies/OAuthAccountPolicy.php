<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\OAuthAccount;
use Modules\Users\Models\User;

class OAuthAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the account.
     */
    public function view(User $user, OAuthAccount $account): bool
    {
        return (int) $account->user_id === (int) $user->id;
    }

    /**
     * Determine whether the user can delete the account.
     */
    public function delete(User $user, OAuthAccount $account): bool
    {
        return (int) $user->id === (int) $account->user_id;
    }
}
