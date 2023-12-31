<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Client\Contracts;

interface SupportSaveToSentFolderParameter
{
    /**
     * Indicates whether the message should be saved
     * to the sent folder after it's sent
     *
     * In most cases, this is valid for new mails not for replies
     *
     * @param  bool  $value
     * @return static
     */
    public function saveToSentFolder($value);
}
