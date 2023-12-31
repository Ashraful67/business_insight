<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Enums;

use Modules\Core\InteractsWithEnums;

enum PhoneType: int
{
    use InteractsWithEnums;

    case mobile = 1;
    case work = 2;
    case other = 3;
}
