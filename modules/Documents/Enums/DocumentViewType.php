<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Enums;

enum DocumentViewType: string
{
    case NAV_TOP = 'nav-top';
    case NAV_LEFT = 'nav-left';
    case NAV_LEFT_FULL_WIDTH = 'nav-left-full-width';
}
