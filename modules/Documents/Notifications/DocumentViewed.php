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
use Modules\Documents\Mail\DocumentViewed as DocumentViewedMailable;
use Modules\Documents\Models\Document;

class DocumentViewed extends Notification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     */
    public function __construct(protected Document $document)
    {
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): DocumentViewedMailable&MailableTemplate
    {
        return $this->viaMailableTemplate(
            new DocumentViewedMailable($this->document),
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
                'key' => 'documents::document.notifications.viewed',
                'attrs' => [
                    'title' => $this->document->title,
                ],
            ],
        ];
    }
}
