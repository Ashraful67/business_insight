<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Concerns;

use Plank\Metable\Metable;

/** @mixin \Modules\Core\Models\Model */
trait HasMeta
{
    use Metable;
}
