<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\MailableTemplate\Exceptions;

use Exception;

class CannotRenderMailableTemplate extends Exception
{
    /**
     * Throw exception
     *
     * @return Exception
     *
     * @throws CannotRenderMailableTemplate
     */
    public static function layoutDoesNotContainABodyPlaceHolder()
    {
        return new static('The layout does not contain a `{{{ mailBody }}}` placeholder');
    }
}
