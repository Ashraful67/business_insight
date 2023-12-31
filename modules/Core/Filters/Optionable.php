<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Filters;

use Modules\Core\Fields\ChangesKeys;
use Modules\Core\Fields\HasOptions;

class Optionable extends Filter
{
    use ChangesKeys,
        HasOptions;
}
