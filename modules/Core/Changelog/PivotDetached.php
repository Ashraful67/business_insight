<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Changelog;

class PivotDetached extends PivotLogger
{
    /**
     * Log pivot detached event
     *
     * Used e.q. when detaching company
     *
     * @param  \Modules\Core\Models\Model  $detachedFrom The model where the pivot is detached
     * @param  array  $pivotIds Attached pivot IDs
     * @param  string  $identifier The relation name the event occured
     * @return null
     */
    public static function log($detachedFrom, $pivotIds, $relation)
    {
        $pivotModels = static::getRelatedPivotIds($detachedFrom, $pivotIds, $relation);

        foreach ($pivotModels as $pivotModel) {
            static::perform($detachedFrom, $pivotModel, $relation, 'detached');
        }
    }
}
