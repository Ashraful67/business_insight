<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Mail;

use Modules\Core\Resource\Placeholders;

class ContactAttendsToActivity extends UserAttendsToActivity
{
    /**
     * Provide the defined mailable template placeholders
     */
    public function placeholders(): Placeholders
    {
        return parent::placeholders()->forget([
            'activity.url', 'action_button', 'activity.note',
            'activity.updated_at', 'activity.created_at', 'activity.reminder_minutes_before',
            'activity.owner_assigned_date', 'activity.reminded_at',
        ]);
    }

    /**
     * Provides the mail template default message
     */
    public static function defaultHtmlTemplate(): string
    {
        return '<p>Hello {{ guest_name }}<br /></p>
                <p>You have been added as a guest of the {{ activity.title }} activity.</p>';
    }

    /**
     * Provides the mail template default subject
     */
    public static function defaultSubject(): string
    {
        return 'You have been added as guest to activity';
    }
}
