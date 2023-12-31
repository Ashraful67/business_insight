<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Filters;

use Modules\Activities\Models\Activity;
use Modules\Core\Filters\Filter;
use Modules\Core\ProvidesBetweenArgumentsViaString;

class DueThisWeekActivities extends Filter
{
    use ProvidesBetweenArgumentsViaString;

    /**
     * Initialize DueThisWeekActivities class
     */
    public function __construct()
    {
        parent::__construct('due_this_week', __('activities::activity.filters.due_this_week'));

        $this->asStatic()->query(function ($builder, $value, $condition) {
            return $builder->where(function ($builder) {
                return $builder->whereBetween(
                    Activity::dueDateQueryExpression(),
                    $this->getBetweenArguments('this_week')
                )->incomplete();
            }, null, null, $condition);
        });
    }
}
