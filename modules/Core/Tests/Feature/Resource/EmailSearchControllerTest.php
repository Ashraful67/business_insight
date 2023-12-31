<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature\Resource;

use Modules\Contacts\Models\Contact;
use Modules\Core\Database\Seeders\PermissionsSeeder;
use Tests\TestCase;

class EmailSearchControllerTest extends TestCase
{
    public function test_unauthenticated_user_cannot_access_the_search_endpoints()
    {
        $this->getJson('/api/search/email-address')->assertUnauthorized();
    }

    public function test_it_returns_all_attributes_when_email_searching()
    {
        $this->signIn();
        Contact::factory()->create(['email' => 'john@example.com']);

        $this->getJson('/api/search/email-address?q=john@example.com')
            ->assertOk()
            ->assertJsonStructure([
                '0' => [
                    'data' => [
                        '0' => [
                            'id',
                            'address',
                            'name',
                            'path',
                            'resourceName',
                        ],
                    ],
                ],
            ]);
    }

    public function test_own_criteria_is_applied_when_email_searching()
    {
        $this->seed(PermissionsSeeder::class);
        $user = $this->asRegularUser()->withPermissionsTo('view own contacts')->signIn();
        $user1 = $this->createUser();

        Contact::factory()->for($user1)->create(['email' => 'example1@example.com']);
        $record = Contact::factory()->for($user)->create(['email' => 'example2@example.com']);

        $this->getJson('/api/search/email-address?q=example')
            ->assertJsonCount(1, '0.data')
            ->assertJsonPath('0.data.0.id', $record->id);
    }

    public function test_it_does_not_return_any_results_if_search_query_is_empty()
    {
        $this->signIn();

        Contact::factory()->create(['email' => 'john@example.com']);

        $this->getJson('/api/search/email-address?q=')
            ->assertJsonCount(0);
    }
}
