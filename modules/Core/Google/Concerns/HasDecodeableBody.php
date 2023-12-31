<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Google\Concerns;

trait HasDecodeableBody
{
    /**
     * @return string
     */
    public function getDecodedBody($content)
    {
        return str_replace('_', '/', str_replace('-', '+', $content));
    }
}
