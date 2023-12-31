<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Import;
use Modules\Users\Models\User;

class ImportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the import.
     */
    public function delete(User $user, Import $import): bool
    {
        return (int) $import->user_id === (int) $user->id;
    }

    /**
     * Determine whether the user can upload fixed skip file.
     */
    public function uploadFixedSkipFile(User $user, Import $import): bool
    {
        return (int) $import->user_id === (int) $user->id;
    }

    /**
     *Determine whether the user can upload fixed skip file
     */
    public function downloadSkipFile(User $user, Import $import): bool
    {
        return (int) $import->user_id === (int) $user->id;
    }
}
