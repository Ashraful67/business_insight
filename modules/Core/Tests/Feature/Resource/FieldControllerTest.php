<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature\Resource;

use Modules\Contacts\Models\Contact;
use Modules\Core\Facades\Fields;
use Modules\Core\Fields\Email;
use Modules\Core\Fields\Text;
use Tests\TestCase;

class FieldControllerTest extends TestCase
{
    public function test_resource_create_fields_can_be_retrieved()
    {
        $this->signIn();

        Fields::replace('contacts', [
            Text::make('first_name'),
            Text::make('last_name'),
            Email::make('make')->hideWhenCreating(),
        ]);

        $this->getJson('/api/contacts/create-fields')->assertJsonCount(2);
    }

    public function test_resource_update_fields_can_be_retrieved()
    {
        $this->signIn();
        $contact = Contact::factory()->create();
        Fields::replace('contacts', [
            Text::make('first_name'),
            Text::make('last_name')->hideWhenUpdating(),
        ]);

        $this->getJson('/api/contacts/'.$contact->id.'/update-fields')->assertJsonCount(1);
    }
}
