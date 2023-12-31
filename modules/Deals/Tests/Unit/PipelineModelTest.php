<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Tests\Unit;

use Modules\Deals\Models\Deal;
use Modules\Deals\Models\Pipeline;
use Tests\TestCase;

class PipelineModelTest extends TestCase
{
    public function test_pipeline_can_be_primary()
    {
        $pipeline = Pipeline::factory()->primary()->create();

        $this->assertTrue($pipeline->isPrimary());
    }

    public function test_pipeline_has_deals()
    {
        $pipeline = Pipeline::factory()->withStages()->has(Deal::factory()->count(2))->create();

        $this->assertCount(2, $pipeline->deals);
    }
}
