<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Tests\Feature\Controller;

use Modules\Activities\Models\Activity;
use Modules\Core\Database\Seeders\PermissionsSeeder;
use Tests\TestCase;

class ActivityStateControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionsSeeder::class);
    }

    public function test_unauthenticated_user_cannot_access_the_activity_end_points()
    {
        $activity = Activity::factory()->create();

        $this->postJson('/api/activities/'.$activity->id.'/complete')->assertUnauthorized();
        $this->postJson('/api/activities/'.$activity->id.'/incomplete')->assertUnauthorized();
    }

    public function test_super_admin_can_change_the_state_of_any_activity()
    {
        $this->signIn();
        $user = $this->createUser();

        $activity = Activity::factory()->for($user)->create();

        $this->postJson('/api/activities/'.$activity->id.'/complete')->assertOk();
        $this->assertTrue($activity->fresh()->isCompleted);

        $this->postJson('/api/activities/'.$activity->id.'/incomplete')->assertOk();
        $this->assertFalse($activity->fresh()->isCompleted);
    }

    public function test_authorized_user_can_change_the_state_to_any_activity()
    {
        $this->asRegularUser()
            ->withPermissionsTo('edit all activities')
            ->signIn();

        $user = $this->createUser();

        $activity = Activity::factory()->for($user)->create();

        $this->postJson('/api/activities/'.$activity->id.'/complete')->assertOk();
        $this->assertTrue($activity->fresh()->isCompleted);

        $this->postJson('/api/activities/'.$activity->id.'/incomplete')->assertOk();
        $this->assertFalse($activity->fresh()->isCompleted);
    }

    public function test_unauthorized_user_can_change_the_state_to_own_activities_only()
    {
        $signedInUser = $this->asRegularUser()
            ->withPermissionsTo('edit own activities')
            ->signIn();

        $user = $this->createUser();

        $activityForSignedIn = Activity::factory()->for($signedInUser)->create();

        $otherTask = Activity::factory()->for($user)->create();

        $this->postJson('/api/activities/'.$otherTask->id.'/complete')->assertForbidden();
        $this->postJson('/api/activities/'.$otherTask->id.'/incomplete')->assertForbidden();

        $this->postJson('/api/activities/'.$activityForSignedIn->id.'/complete')->assertOk();
        $this->postJson('/api/activities/'.$activityForSignedIn->id.'/incomplete')->assertOk();
    }
}
