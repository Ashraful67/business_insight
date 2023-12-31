<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Calls\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Calls\Models\CallOutcome;
use Modules\Users\Models\User;

class CallOutcomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any outcomes.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the outcome.
     */
    public function view(User $user, CallOutcome $outcome): bool
    {
        return true;
    }

    /**
     * Determine if the given user can create outcome.
     */
    public function create(User $user): bool
    {
        // Only super admins
        return false;
    }

    /**
     * Determine whether the user can update the outcome.
     */
    public function update(User $user, CallOutcome $outcome): bool
    {
        // Only super admins
        return false;
    }

    /**
     * Determine whether the user can delete the outcome.
     */
    public function delete(User $user, CallOutcome $outcome): bool
    {
        // Only super admins
        return false;
    }
}
