<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Timeline;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Core\Models\PinnedTimelineSubject;

trait HasTimeline
{
    /**
     * Boot the HasTimeline trait
     */
    protected static function bootHasTimeline(): void
    {
        static::deleting(function ($model) {
            if (! $model->usesSoftDeletes() || $model->isForceDeleting()) {
                $model->pinnedTimelineables->each->delete();
            }
        });
    }

    /**
     * Get the timeline subject key
     */
    public static function getTimelineSubjectKey(): string
    {
        return strtolower(class_basename(get_called_class()));
    }

    /**
     * Get the subject pinned timelineables models
     */
    public function pinnedTimelineables(): MorphMany
    {
        return $this->morphMany(PinnedTimelineSubject::class, 'subject');
    }
}
