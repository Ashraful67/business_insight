<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Concerns;

use Modules\MailClient\Client\Imap\Config as ImapConfig;
use Modules\MailClient\Client\Imap\SmtpConfig;

trait EmailAccountImap
{
    /**
     * Get the Imap client configuration
     */
    public function getImapConfig(): ImapConfig
    {
        return new ImapConfig(
            $this->imap_server,
            $this->imap_port,
            $this->imap_encryption,
            $this->email,
            $this->validate_cert,
            $this->username,
            $this->password
        );
    }

    /**
     * Get the Smtp client configuration
     */
    public function getSmtpConfig(): SmtpConfig
    {
        return new SmtpConfig(
            $this->smtp_server,
            $this->smtp_port,
            $this->smtp_encryption,
            $this->email,
            $this->validate_cert,
            $this->username,
            $this->password
        );
    }
}
