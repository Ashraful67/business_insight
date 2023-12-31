<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Highlights;

use Modules\Activities\Criteria\ViewAuthorizedActivitiesCriteria;
use Modules\Activities\Models\Activity;
use Modules\Core\Highlights\Highlight;
use Modules\Core\Models\Filter;

class TodaysActivities extends Highlight
{
    /**
     * Get the highlight name
     */
    public function name(): string
    {
        return __('activities::activity.highlights.todays');
    }

    /**
     * Get the highligh count
     */
    public function count(): int
    {
        return Activity::dueToday()->criteria(ViewAuthorizedActivitiesCriteria::class)->count();
    }

    /**
     * Get the background color class when the highligh count is bigger then zero
     */
    public function bgColorClass(): string
    {
        return 'bg-warning-500';
    }

    /**
     * Get the front-end route that the highly will redirect to
     */
    public function route(): array|string
    {
        $filter = Filter::findByFlag('due-today-activities');

        return [
            'name' => 'activity-index',
            'query' => [
                'filter_id' => $filter?->id,
            ],
        ];
    }
}
