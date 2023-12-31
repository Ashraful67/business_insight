<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;

interface Presentable
{
    public function displayName(): Attribute;

    public function path(): Attribute;

    public function getKeyName();

    public function getKey();
}
