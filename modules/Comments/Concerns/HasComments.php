<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Comments\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comments\Models\Comment;
use Modules\Users\Mention\PendingMention;

/** @mixin \Modules\Core\Models\Model */
trait HasComments
{
    /**
     * Boot the HasComments trait
     */
    protected static function bootHasComments(): void
    {
        static::deleting(function ($model) {
            if (! $model->usesSoftDeletes() || $model->isForceDeleting()) {
                $model->comments->each->delete();
            }
        });
    }

    /**
     * Get all of the model comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->orderBy('created_at');
    }

    /**
     * Add new comment for the commentable.
     */
    public function addComment(array $attributes): Comment
    {
        $mention = new PendingMention($attributes['body']);
        $attributes['body'] = $mention->getUpdatedText();

        $comment = $this->comments()->create($attributes);

        $comment->notifyMentionedUsers(
            $mention,
            $attributes['via_resource'] ?? null,
            $attributes['via_resource_id'] ?? null
        );

        return $comment->loadMissing('creator');
    }
}
