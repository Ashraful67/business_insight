<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature;

use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    public function test_unauthenticated_cannot_access_currency_endpoints()
    {
        $this->getJson('/api/currencies')->assertUnauthorized();
    }

    public function test_user_can_fetch_currencies()
    {
        $this->signIn();

        $this->getJson('/api/currencies')
            ->assertOk()
            ->assertJson(config('money'));
    }
}
