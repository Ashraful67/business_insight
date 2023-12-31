<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Tests\Feature\Actions;

use Modules\Billable\Actions\MarkProductAsInactive;
use Modules\Core\Database\Seeders\PermissionsSeeder;
use Modules\Core\Tests\ResourceTestCase;

class MarkProductAsInactiveTest extends ResourceTestCase
{
    protected $action;

    protected $resourceName = 'products';

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = new MarkProductAsInactive;
    }

    protected function tearDown(): void
    {
        unset($this->action);
        parent::tearDown();
    }

    public function test_super_admin_user_can_run_mark_as_inactive_action()
    {
        $this->signIn();
        $product = $this->factory()->active()->create();

        $this->postJson($this->actionEndpoint($this->action), [
            'ids' => [$product->id],
        ])->assertOk();

        $this->assertFalse($product->fresh()->is_active);
    }

    public function test_authorized_user_can_run_mark_as_inactive_action()
    {
        $this->seed(PermissionsSeeder::class);
        $this->asRegularUser()->withPermissionsTo('edit all products')->signIn();

        $user = $this->createUser();
        $product = $this->factory()->active()->for($user, 'creator')->create();

        $this->postJson($this->actionEndpoint($this->action), [
            'ids' => [$product->id],
        ])->assertOk();

        $this->assertFalse($product->fresh()->is_active);
    }

    public function test_unauthorized_user_can_run_mark_as_inactive_action_on_own_deal()
    {
        $this->seed(PermissionsSeeder::class);
        $signedInUser = $this->asRegularUser()->withPermissionsTo('edit own products')->signIn();
        $this->createUser();

        $productForSignedIn = $this->factory()->active()->for($signedInUser, 'creator')->create();
        $otherProduct = $this->factory()->active()->create();

        $this->postJson($this->actionEndpoint($this->action), [
            'ids' => [$otherProduct->id],
        ])->assertJson(['error' => __('users::user.not_authorized')]);

        $this->postJson($this->actionEndpoint($this->action), [
            'ids' => [$productForSignedIn->id],
        ]);

        $this->assertFalse($productForSignedIn->fresh()->is_active);
    }
}
