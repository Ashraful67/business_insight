<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Tests\Feature\Controller;

use Modules\Activities\Models\Activity;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    public function test_unauthenticated_user_cannot_access_the_activity_end_points()
    {
        $activity = Activity::factory()->create();

        $this->getJson('/api/activities/'.$activity->id.'/ics')->assertUnauthorized();
    }

    public function test_activity_ics_file_can_be_downloaded()
    {
        $this->signIn();

        $activity = Activity::factory()->create();

        $this->getJson('/api/activities/'.$activity->getKey().'/ics')
            ->assertHeader('Content-Type', 'text/calendar; charset=UTF-8')
            ->assertHeader('Content-Disposition', 'attachment; filename='.$activity->icsFilename().'.ics');
    }
}
