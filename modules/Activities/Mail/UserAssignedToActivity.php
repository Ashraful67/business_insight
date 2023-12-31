<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Activities\Models\Activity;
use Modules\Activities\Resource\Activity as ResourceActivity;
use Modules\Core\MailableTemplate\DefaultMailable;
use Modules\Core\Placeholders\ActionButtonPlaceholder;
use Modules\Core\Placeholders\PrivacyPolicyPlaceholder;
use Modules\Core\Resource\Placeholders;
use Modules\MailClient\Mail\MailableTemplate;
use Modules\Users\Models\User;
use Modules\Users\Placeholders\UserPlaceholder;

class UserAssignedToActivity extends MailableTemplate implements ShouldQueue
{
    /**
     * Create a new mailable template instance.
     */
    public function __construct(protected Activity $activity, protected User $assigneer)
    {
    }

    /**
     * Provide the defined mailable template placeholders
     */
    public function placeholders(): Placeholders
    {
        return (new Placeholders(new ResourceActivity, $this->activity ?? null))->push([
            ActionButtonPlaceholder::make(fn () => $this->activity),
            PrivacyPolicyPlaceholder::make(),
            UserPlaceholder::make(fn () => $this->assigneer->name, 'assigneer')
                ->description(__('activities::activity.mail_placeholders.assigneer')),
        ])->withUrlPlaceholder();
    }

    /**
     * Provides the mail template default configuration
     */
    public static function default(): DefaultMailable
    {
        return new DefaultMailable(static::defaultHtmlTemplate(), static::defaultSubject());
    }

    /**
     * Provides the mail template default message
     */
    public static function defaultHtmlTemplate(): string
    {
        return '<p>Hello {{ activity.user }}<br /></p>
                <p>You have been assigned to activity {{ activity.name }} by {{ assigneer }}<br /></p>
                <p>{{#action_button}}View Activity{{/action_button}}</p>';
    }

    /**
     * Provides the mail template default subject
     */
    public static function defaultSubject(): string
    {
        return 'You are added as an owner of the activity {{ activity.title }}';
    }
}
