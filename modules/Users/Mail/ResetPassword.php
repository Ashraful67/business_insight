<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Mail;

use Illuminate\Contracts\Routing\UrlGenerator;
use Modules\Core\MailableTemplate\DefaultMailable;
use Modules\Core\MailableTemplate\MailableTemplate;
use Modules\Core\Placeholders\ActionButtonPlaceholder;
use Modules\Core\Placeholders\Collection as BasePlaceholders;
use Modules\Core\Placeholders\GenericPlaceholder;

class ResetPassword extends MailableTemplate
{
    /**
     * Create a new message instance.
     */
    public function __construct(public UrlGenerator|string $url)
    {
    }

    /**
     * Provide the defined mailable template placeholders
     */
    public function placeholders(): BasePlaceholders
    {
        return new BasePlaceholders([
            GenericPlaceholder::make(
                'expiration_minutes',
                config('auth.passwords.'.config('auth.defaults.passwords').'.expire')
            ),
            ActionButtonPlaceholder::make(fn () => $this->url),
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
        return '<p>You are receiving this email because we received a password reset request for your account.</p>
                <p>{{#action_button}}Reset Password{{/action_button}}</p>
                <p>This password reset link will expire in {{ expiration_minutes }} minutes.</p>
                <p>If you did not request a password reset, no further action is required.</p>';
    }

    /**
     * Provides the mail template default subject
     */
    public static function defaultSubject(): string
    {
        return 'Reset Your Password';
    }
}
