<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Modules\Core\Table\MorphToManyColumn;

class MorphToMany extends HasMany
{
    /**
     * Provide the column used for index
     */
    public function indexColumn(): MorphToManyColumn
    {
        return tap(new MorphToManyColumn(
            $this->hasManyRelationship,
            $this->labelKey,
            $this->label
        ), function ($column) {
            if ($this->counts()) {
                $column->count()->centered()->sortable();
            }
        });
    }
}
