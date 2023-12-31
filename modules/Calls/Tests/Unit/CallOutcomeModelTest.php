<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Calls\Tests\Unit;

use Modules\Calls\Models\Call;
use Modules\Calls\Models\CallOutcome;
use Tests\TestCase;

class CallOutcomeModelTest extends TestCase
{
    public function test_outcome_has_calls()
    {
        $outcome = CallOutcome::factory()->has(Call::factory()->count(2))->create();

        $this->assertCount(2, $outcome->calls);
    }
}
