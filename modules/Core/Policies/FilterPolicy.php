<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Filter;
use Modules\Users\Models\User;

class FilterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the filter.
     */
    public function update(User $user, Filter $filter): bool
    {
        return (int) $filter->user_id === (int) $user->id;
    }

    /**
     * Determine whether the user can delete the filter.
     */
    public function delete(User $user, Filter $filter): bool
    {
        return (int) $filter->user_id === (int) $user->id;
    }
}
