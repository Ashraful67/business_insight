<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Contacts\Mail\UserAssignedToCompany as AssignedToCompanyMailable;
use Modules\Contacts\Models\Company;
use Modules\Core\MailableTemplate\MailableTemplate;
use Modules\Core\Notification;
use Modules\Users\Models\User;

class UserAssignedToCompany extends Notification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     */
    public function __construct(protected Company $company, protected User $assigneer)
    {
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): AssignedToCompanyMailable&MailableTemplate
    {
        return $this->viaMailableTemplate(
            new AssignedToCompanyMailable($this->company, $this->assigneer),
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
            'path' => $this->company->path,
            'lang' => [
                'key' => 'contacts::company.notifications.assigned',
                'attrs' => [
                    'user' => $this->assigneer->name,
                    'name' => $this->company->display_name,
                ],
            ],
        ];
    }
}
