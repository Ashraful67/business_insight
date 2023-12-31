<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Workflow\Triggers;

use Modules\Activities\Workflow\Actions\CreateActivityAction;
use Modules\Core\Contracts\Workflow\EventTrigger;
use Modules\Core\Contracts\Workflow\ModelTrigger;
use Modules\Core\Workflow\Actions\WebhookAction;
use Modules\Core\Workflow\Trigger;
use Modules\MailClient\Workflow\Actions\ResourcesSendEmailToField;
use Modules\MailClient\Workflow\Actions\SendEmailAction;

class ContactCreated extends Trigger implements ModelTrigger, EventTrigger
{
    /**
     * Trigger name
     */
    public static function name(): string
    {
        return __('contacts::contact.workflows.triggers.created');
    }

    /**
     * The trigger related model
     */
    public static function model(): string
    {
        return \Modules\Contacts\Models\Contact::class;
    }

    /**
     * The model event trigger
     */
    public static function event(): string
    {
        return 'created';
    }

    /**
     * Trigger available actions
     */
    public function actions(): array
    {
        return [
            new CreateActivityAction,
            (new SendEmailAction)->toResources(ResourcesSendEmailToField::make()->options([
                'self' => [
                    'label' => __('contacts::contact.workflows.actions.fields.email_to_contact'),
                    'resource' => 'contacts',
                ],
                'user' => [
                    'label' => __('contacts::contact.workflows.actions.fields.email_to_owner_email'),
                    'resource' => 'users',
                ],
                'creator' => [
                    'label' => __('contacts::contact.workflows.actions.fields.email_to_creator_email'),
                    'resource' => 'users',
                ],
                'companies' => [
                    'label' => __('contacts::contact.workflows.actions.fields.email_to_company'),
                    'resource' => 'companies',
                ],
            ])),
            new WebhookAction,
        ];
    }
}
