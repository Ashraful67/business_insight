<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts\Services;

use Modules\Core\Models\Model;

interface UpdateService
{
    public function update(Model $model, array $attributes): Model;
}
