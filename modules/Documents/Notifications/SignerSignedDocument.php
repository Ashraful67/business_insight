<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Core\MailableTemplate\MailableTemplate;
use Modules\Core\Notification;
use Modules\Documents\Mail\SignerSignedDocument as SignerSignedDocumentMailable;
use Modules\Documents\Models\Document;
use Modules\Documents\Models\DocumentSigner;

class SignerSignedDocument extends Notification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     */
    public function __construct(protected Document $document, protected DocumentSigner $signer)
    {
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): SignerSignedDocumentMailable&MailableTemplate
    {
        return $this->viaMailableTemplate(
            new SignerSignedDocumentMailable($this->document, $this->signer),
            $notifiable
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'path' => $this->document->path,
            'lang' => [
                'key' => 'documents::document.notifications.signed',
                'attrs' => [
                    'title' => $this->document->title,
                ],
            ],
        ];
    }
}
