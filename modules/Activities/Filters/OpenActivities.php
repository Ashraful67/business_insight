<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Filters;

use Modules\Core\Filters\Filter;

class OpenActivities extends Filter
{
    /**
     * Initialize OpenActivities Class
     */
    public function __construct()
    {
        parent::__construct('open_activities', __('activities::activity.filters.open'));

        $this->asStatic()->query(function ($builder, $value, $condition) {
            return $builder->where(fn ($builder) => $builder->incomplete(), null, null, $condition);
        });
    }
}
