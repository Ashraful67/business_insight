<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

class Html2Text
{
    /**
     * Convert HTML to Text
     *
     * @param  string  $html
     * @return string
     */
    public static function convert($html)
    {
        return \Soundasleep\Html2Text::convert($html, ['ignore_errors' => true]);
    }
}
