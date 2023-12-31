<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature;

use Tests\TestCase;

class FilePermissionErrorTest extends TestCase
{
    public function test_file_permissions_can_be_viewed()
    {
        $this->signIn();

        $this->get('/errors/permissions')->assertOk();
    }
}
