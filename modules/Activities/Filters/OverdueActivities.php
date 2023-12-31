<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Filters;

use Modules\Core\Filters\Radio;

class OverdueActivities extends Radio
{
    /**
     * Create new instance of OverdueActivities class
     */
    public function __construct()
    {
        parent::__construct('overdue', __('activities::activity.overdue'));

        $this->options(['yes' => __('core::app.yes'), 'no' => __('core::app.no')])
            ->query(function ($builder, $value, $condition) {
                return $builder->where(fn ($builder) => $builder->overdue($value === 'yes' ? '<=' : '>'), null, null, $condition);
            });
    }
}
