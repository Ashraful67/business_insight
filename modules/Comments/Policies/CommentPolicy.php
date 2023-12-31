<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Comments\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Comments\Models\Comment;
use Modules\Users\Models\User;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the comment.
     */
    public function view(User $user, Comment $comment): bool
    {
        return (int) $user->id === (int) $comment->created_by;
    }

    /**
     * Determine whether the user can update the comment.
     */
    public function update(User $user, Comment $comment): bool
    {
        return (int) $user->id === (int) $comment->created_by;
    }

    /**
     * Determine whether the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return (int) $user->id === (int) $comment->created_by;
    }
}
