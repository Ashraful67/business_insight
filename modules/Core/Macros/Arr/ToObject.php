<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Macros\Arr;

class ToObject
{
    public function __invoke($array)
    {
        if (! is_array($array) && ! is_object($array)) {
            return new \stdClass();
        }

        return json_decode(json_encode((object) $array));
    }
}
