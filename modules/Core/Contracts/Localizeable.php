<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts;

interface Localizeable
{
    public function getLocalTimeFormat();

    public function getLocalDateFormat();

    public function getUserTimezone();
}
