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
use Modules\Core\Placeholders\GenericPlaceholder;
use Modules\Core\Placeholders\PrivacyPolicyPlaceholder;
use Modules\Core\Resource\Placeholders;
use Modules\Documents\Models\Document;
use Modules\Documents\Models\DocumentSigner;
use Modules\Documents\Resource\Document as ResourceDocument;
use Modules\MailClient\Mail\MailableTemplate;

class SignerSignedDocument extends MailableTemplate implements ShouldQueue
{
    /**
     * Create a new mailable instance.
     */
    public function __construct(protected Document $document, protected DocumentSigner $signer)
    {
    }

    /**
     * Provide the defined mailable template placeholders
     */
    public function placeholders(): Placeholders
    {
        return (new Placeholders(new ResourceDocument, $this->document ?? null))->push([
            GenericPlaceholder::make('signer_name', fn () => $this->signer->name),
            ActionButtonPlaceholder::make(fn () => $this->document),
            PrivacyPolicyPlaceholder::make(),
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
                <p>Your {{ document.title }} document has been signed by {{ signer_name }}<br /></p>
                <p>{{#action_button}}View Document{{/action_button}}</p>';
    }

    /**
     * Provides the mail template default subject
     */
    public static function defaultSubject(): string
    {
        return 'Your {{ document.title }} document has been signed';
    }
}
