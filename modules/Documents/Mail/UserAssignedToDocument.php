<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Core\MailableTemplate\DefaultMailable;
use Modules\Core\Placeholders\ActionButtonPlaceholder;
use Modules\Core\Placeholders\PrivacyPolicyPlaceholder;
use Modules\Core\Resource\Placeholders;
use Modules\Documents\Models\Document;
use Modules\Documents\Resource\Document as ResourceDocument;
use Modules\MailClient\Mail\MailableTemplate;
use Modules\Users\Models\User;
use Modules\Users\Placeholders\UserPlaceholder;

class UserAssignedToDocument extends MailableTemplate implements ShouldQueue
{
    /**
     * Create a new mailable template instance.
     */
    public function __construct(protected Document $document, protected User $assigneer)
    {
    }

    /**
     * Provide the defined mailable template placeholders
     */
    public function placeholders(): Placeholders
    {
        return (new Placeholders(new ResourceDocument, $this->document ?? null))->push([
            ActionButtonPlaceholder::make(fn () => $this->document),
            PrivacyPolicyPlaceholder::make(),
            UserPlaceholder::make(fn () => $this->assigneer->name, 'assigneer')
                ->description(__('documents::document.mail_placeholders.assigneer')),
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
        return '<p>Hello {{ document.user }}<br /></p>
                <p>You have been assigned to a document {{ document.title }} by {{ assigneer }}<br /></p>
                <p>{{#action_button}}View Document{{/action_button}}</p>';
    }

    /**
     * Provides the mail template default subject
     */
    public static function defaultSubject(): string
    {
        return 'You are added as an owner of the document {{ document.title }}';
    }
}