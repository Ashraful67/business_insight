<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\HtmlPurifier;

use HTMLPurifier_AttrDef;

class HTMLPurifier_AttrDef_CSS_Flex extends HTMLPurifier_AttrDef
{
    /**
     * @param  string  $string
     * @param  HTMLPurifier_Config  $config
     * @param  HTMLPurifier_Context  $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $string = $this->parseCDATA($string);

        if ($string === '') {
            return false;
        }

        return clean($string);
    }
}
