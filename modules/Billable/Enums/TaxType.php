<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Enums;

use Modules\Core\InteractsWithEnums;

enum TaxType: int
{
    use InteractsWithEnums;

    case exclusive = 1;
    case inclusive = 2;
    case no_tax = 3;
}
