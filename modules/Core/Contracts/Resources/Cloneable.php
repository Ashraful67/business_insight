<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Resources;

use Modules\Core\Models\Model;

interface Cloneable
{
    /**
     * Clone the resource record from the given id
     */
    public function clone(Model $model, int $userId): Model;
}
