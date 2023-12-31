<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Notifications;

use Modules\Core\Contracts\Metable;
use Modules\Core\MailableTemplate\MailableTemplate;
use Modules\Core\Notification;
use Modules\Users\Mail\ResetPassword as ResetPasswordMailable;

class ResetPassword extends Notification
{
    /**
     * Create a notification instance.
     */
    public function __construct(public string $token)
    {
    }

    /**
     * Get the notification's channels.
     */
    public function via(Metable $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail(object $notifiable): ResetPasswordMailable&MailableTemplate
    {
        return $this->viaMailableTemplate(
            new ResetPasswordMailable($this->resetUrl($notifiable)),
            $notifiable
        );
    }

    /**
     * Get the reset URL for the given notifiable.
     */
    protected function resetUrl(object $notifiable): string
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }

    /**
     * Define whether the notification is user-configurable
     */
    public static function configurable(): bool
    {
        return false;
    }
}
