<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Fields;

use Modules\Activities\Models\Activity;
use Modules\Core\Facades\Format;
use Modules\Core\Fields\BelongsTo;

class NextActivityDate extends BelongsTo
{
    /**
     * Initialize new NextActivityDate instance
     */
    public function __construct()
    {
        parent::__construct(
            'nextActivity',
            Activity::class,
            __('activities::activity.next_activity_date'),
            'next_activity_date'
        );

        $this->exceptOnForms()
            ->excludeFromImport()
            ->help(__('activities::activity.next_activity_date_info'))
            ->hidden();

        $this->resolveUsing(function ($model) {
            if ($model->relationLoaded('nextActivity')) {
                return $model->nextActivity?->full_due_date;
            }
        });

        $this->displayUsing(function ($model) {
            if ($model->relationLoaded('nextActivity') && $model->nextActivity) {
                return Format::separateDateAndTime(
                    $model->nextActivity->due_date,
                    $model->nextActivity->due_time
                );
            }
        });

        $this->tapIndexColumn(function ($column) {
            $column->orderByColumn(function ($data) {
                return Activity::dueDateQueryExpression();
            })
                ->select(['due_time'])
                ->queryAs(Activity::dueDateQueryExpression('next_activity_date'))
                ->displayAs(function ($model) {
                    if ($model->nextActivity) {
                        $date = $model->nextActivity->next_activity_date;
                        $method = $model->nextActivity->due_time ? 'dateTime' : 'date';

                        return Format::$method($date);
                    }

                    return '--';
                });
        });
    }
}
