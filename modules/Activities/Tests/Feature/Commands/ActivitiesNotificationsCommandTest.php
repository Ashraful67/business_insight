<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Tests\Feature\Commands;

use Illuminate\Support\Facades\Notification;
use Modules\Activities\Models\Activity;
use Modules\Activities\Notifications\ActivityReminder;
use Tests\TestCase;

class ActivitiesNotificationsCommandTest extends TestCase
{
    public function test_activities_notifications_command()
    {
        Notification::fake();

        $activity = Activity::factory()->create([
            'due_date' => date('Y-m-d', strtotime('+30 minutes')),
            'due_time' => date('H:i:s', strtotime('+30 minutes')),
            'reminder_minutes_before' => 30,
        ]);

        $this->artisan('activities:due-notifications')
            ->assertSuccessful();

        Notification::assertSentTo($activity->user, ActivityReminder::class);
        Notification::assertSentToTimes($activity->user, ActivityReminder::class, 1);

        $this->assertNotNull($activity->fresh()->reminded_at);
    }
}
