<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature;

use Tests\TestCase;

class TimezoneControllerTest extends TestCase
{
    public function test_unauthenticated_user_cannot_access_timezones_endpoints()
    {
        $this->getJson('/api/timezones')->assertUnauthorized();
    }

    public function test_timezones_can_be_retrieved()
    {
        $this->signIn();

        $this->getJson('/api/timezones')->assertOk();
    }
}
