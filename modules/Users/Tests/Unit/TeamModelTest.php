<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Tests\Unit;

use Modules\Users\Models\Team;
use Modules\Users\Models\User;
use Tests\TestCase;

class TeamModelTest extends TestCase
{
    public function test_team_has_users()
    {
        $team = Team::factory()->has(User::factory()->count(2))->create();

        $this->assertCount(2, $team->users);
    }
}
