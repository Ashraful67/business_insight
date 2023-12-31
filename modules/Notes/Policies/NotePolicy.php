<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Notes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Resource\Http\ResourceRequest;
use Modules\Notes\Models\Note;
use Modules\Users\Models\User;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any notes.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the note.
     */
    public function view(User $user, Note $note): bool
    {
        return (int) $user->id === (int) $note->user_id;
    }

    /**
     * Determine if the given user can create notes.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the note.
     */
    public function update(User $user, Note $note): bool
    {
        return (int) $user->id === (int) $note->user_id;
    }

    /**
     * Determine whether the user can delete the note.
     */
    public function delete(User $user, Note $note): bool
    {
        return (int) $user->id === (int) $note->user_id;
    }

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        $request = app(ResourceRequest::class);

        if ($ability === 'view' && $request->viaResource()) {
            return $request->findResource($request->get('via_resource'))
                ->newModel()
                ->find($request->get('via_resource_id'))
                ->notes
                ->contains(
                    $request->route()->parameter('resourceId')
                );
        }

        return null;
    }
}
