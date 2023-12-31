<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Activities\Mail\ActivityReminder as ReminderMailable;
use Modules\Activities\Models\Activity;
use Modules\Core\Facades\Format;
use Modules\Core\MailableTemplate\MailableTemplate;
use Modules\Core\Notification;

class ActivityReminder extends Notification implements ShouldQueue
{
    /**
     * Create a new notification instance.
     */
    public function __construct(protected Activity $activity)
    {
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): ReminderMailable&MailableTemplate
    {
        return $this->viaMailableTemplate(
            new ReminderMailable($this->activity),
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
            'path' => $this->activity->path,
            'lang' => [
                'key' => 'activities::activity.notifications.due',
                'attrs' => [
                    'activity' => $this->activity->title,
                    'date' => $this->activity->due_time ?
                     Format::dateTime($this->activity->full_due_date, $this->activity->user) :
                     Format::date($this->activity->due_date, $this->activity->user),
                ],
            ],
        ];
    }
}
