<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature\Workflow;

use Modules\Activities\Models\ActivityType;
use Modules\Core\Workflow\Workflows;
use Tests\TestCase;

class WorkflowTriggersControllerTest extends TestCase
{
    public function test_unauthenticated_cannot_access_workflow_triggers_endpoints()
    {
        $this->getJson('/api/workflows/triggers')->assertUnauthorized();
    }

    public function test_workflow_triggers_can_be_retrieved()
    {
        ActivityType::factory()->create(['flag' => 'task']);

        $this->signIn();

        $this->getJson('/api/workflows/triggers')
            ->assertJsonCount(Workflows::triggersInstance()->count());
    }
}
