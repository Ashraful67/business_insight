<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Contacts\Models\Source;
use Modules\Users\Models\User;

class SourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any sources.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the source.
     */
    public function view(User $user, Source $source): bool
    {
        return true;
    }

    /**
     * Determine if the given user can create source.
     */
    public function create(User $user): bool
    {
        // Only super admins
        return false;
    }

    /**
     * Determine whether the user can update the source.
     */
    public function update(User $user, Source $source): bool
    {
        // Only super admins
        return false;
    }

    /**
     * Determine whether the user can delete the source.
     */
    public function delete(User $user, Source $source): bool
    {
        // Only super admins
        return false;
    }
}
