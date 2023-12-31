<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Activities\Contracts\Attendeeable;
use Modules\Activities\Mail\UserAttendsToActivity as UserAttendsToActivityMailable;
use Modules\Activities\Models\Activity;
use Modules\Core\MailableTemplate\MailableTemplate;
use Modules\Core\Notification;

class UserAttendsToActivity extends Notification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     */
    public function __construct(protected Attendeeable $guestable, protected Activity $activity)
    {
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): UserAttendsToActivityMailable&MailableTemplate
    {
        return $this->viaMailableTemplate(
            new UserAttendsToActivityMailable($this->guestable, $this->activity),
            $notifiable
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'path' => $this->activity->path,
            'lang' => [
                'key' => 'activities::activity.notifications.added_as_guest',
                'attrs' => [],
            ],
        ];
    }
}
