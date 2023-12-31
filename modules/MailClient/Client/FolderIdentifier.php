<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Client;

class FolderIdentifier
{
    /**
     * Initialize new FolderIdentifier class
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function __construct(public $key, public $value)
    {
    }
}
