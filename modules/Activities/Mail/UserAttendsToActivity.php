<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Activities\Contracts\Attendeeable;
use Modules\Activities\Models\Activity;
use Modules\Activities\Resource\Activity as ResourceActivity;
use Modules\Core\MailableTemplate\DefaultMailable;
use Modules\Core\Placeholders\ActionButtonPlaceholder;
use Modules\Core\Placeholders\GenericPlaceholder;
use Modules\Core\Placeholders\PrivacyPolicyPlaceholder;
use Modules\Core\Resource\Placeholders;
use Modules\MailClient\Mail\MailableTemplate;

class UserAttendsToActivity extends MailableTemplate implements ShouldQueue
{
    /**
     * Create a new mailable template instance.
     */
    public function __construct(protected Attendeeable $guestable, protected Activity $activity)
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
            GenericPlaceholder::make('guest_name', fn () => $this->guestable->getGuestDisplayName())
                ->description(__('activities::activity.guest')),
            GenericPlaceholder::make('guest_email', fn () => $this->guestable->getGuestEmail()),
        ])->withUrlPlaceholder();
    }

    /**
     * Build the mailable template with additional data
     *
     * @return static
     */
    public function build()
    {
        return $this->attachData($this->activity->generateICSInstance()->get(), 'invite.ics', [
            'mime' => 'text/calendar',
        ]);
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
        return '<p>Hello {{ guest_name }}<br /></p>
                <p>You have been added as a guest of the {{ activity.title }} activity<br /></p>
                <p>{{#action_button}}View Activity{{/action_button}}</p>';
    }

    /**
     * Provides the mail template default subject
     */
    public static function defaultSubject(): string
    {
        return 'You have been added as guest to activity';
    }
}
