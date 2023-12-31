<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Tests\Unit;

use Modules\MailClient\Models\PredefinedMailTemplate;
use Modules\Users\Models\User;
use Tests\TestCase;

class PredefinedMailTemplateTest extends TestCase
{
    public function test_predefined_mail_template_has_user()
    {
        $template = PredefinedMailTemplate::factory()->for(User::factory())->create();

        $this->assertInstanceOf(User::class, $template->user);
    }
}
