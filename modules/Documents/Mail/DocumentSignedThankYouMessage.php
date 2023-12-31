<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Mail;

class DocumentSignedThankYouMessage extends DocumentMailable
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('documents::mail.thankyou')
            ->with(['content' => $this->document->brand->config['document']['signed_mail_message']])
            ->subject($this->document->brand->config['document']['signed_mail_subject']);
    }
}
