<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Unit\Models;

use Modules\Core\Models\ZapierHook;
use Modules\Users\Models\User;
use Tests\TestCase;

class ZapierHookTest extends TestCase
{
    public function test_zapier_hook_has_user()
    {
        $user = $this->createUser();

        $hook = new ZapierHook([
            'hook' => 'created',
            'action' => 'create',
            'resource_name' => 'resource',
            'user_id' => $user->id,
            'zap_id' => 123,
        ]);

        $hook->save();

        $this->assertInstanceOf(User::class, $hook->user);
    }
}
