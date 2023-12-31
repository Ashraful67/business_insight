<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Activities\Criteria\ViewAuthorizedActivitiesCriteria;

/** @mixin \Modules\Core\Models\Model */
trait HasActivities
{
    /**
     * Get all of the associated activities for the record.
     */
    public function activities(): MorphToMany
    {
        return $this->morphToMany(\Modules\Activities\Models\Activity::class, 'activityable');
    }

    /**
     * A record has incomplete activities
     */
    public function incompleteActivities(): MorphToMany
    {
        return $this->activities()->incomplete();
    }

    /**
     * Get the incomplete activities for the user
     */
    public function incompleteActivitiesForUser(): MorphToMany
    {
        return $this->incompleteActivities()->criteria(ViewAuthorizedActivitiesCriteria::class);
    }

    /**
     * Get the model next activity
     */
    public function nextActivity(): BelongsTo
    {
        return $this->belongsTo(\Modules\Activities\Models\Activity::class, 'next_activity_id');
    }
}
