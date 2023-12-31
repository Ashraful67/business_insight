<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Changelog;

class PivotAttached extends PivotLogger
{
    /**
     * Log pivot attached event
     *
     * Used e.q. when attaching company
     *
     * @param  \Modules\Core\Models\Model  $attachedTo The model where the pivot is attached
     * @param  array  $pivotIds Attached pivot IDs
     * @param  string  $relation The relation name the event occured
     * @return null
     */
    public static function log($attachedTo, $pivotIds, $relation)
    {
        $pivotModels = static::getRelatedPivotIds($attachedTo, $pivotIds, $relation);

        foreach ($pivotModels as $pivotModel) {
            static::perform($attachedTo, $pivotModel, $relation, 'attached');
        }
    }
}
