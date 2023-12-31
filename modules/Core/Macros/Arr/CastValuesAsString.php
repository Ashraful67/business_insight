<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Macros\Arr;

class CastValuesAsString
{
    /**
     * Cast the provided array values as string
     *
     * @param  array  $array
     * @return array
     */
    public function __invoke($array)
    {
        return array_map(fn ($value) => (string) $value, $array);
    }
}
