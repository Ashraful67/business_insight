<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Filters;

interface CountableRelation
{
    /**
     * Indicates that the filter will count the values of the relation
     *
     * @param  string|null  $relationName
     * @return \Modules\Core\Filters\Filter
     */
    public function countableRelation($relationName = null);

    /**
     * Get the countable relation name
     *
     * @return string|null
     */
    public function getCountableRelation();
}
