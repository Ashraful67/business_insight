<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature;

use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    public function test_it_always_uses_the_default_app_view()
    {
        $this->signIn();

        $this->get('/')->assertViewIs('core::app');
        $this->get('/non-existent-page')->assertViewIs('core::app');
    }
}
