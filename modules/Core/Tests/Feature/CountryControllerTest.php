<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature;

use Modules\Core\Database\Seeders\CountriesSeeder;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    public function test_unauthenticated_cannot_access_country_endpoints()
    {
        $this->getJson('/api/countries')->assertUnauthorized();
    }

    public function test_user_can_fetch_countries()
    {
        $this->signIn();

        $this->seed(CountriesSeeder::class);

        $this->getJson('/api/countries')->assertOk();
    }
}
