<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Database\State;

use Modules\Core\Facades\MailableTemplates;
use ReflectionMethod;

class EnsureMailableTemplatesArePresent
{
    public function __invoke()
    {
        if (! MailableTemplates::requiresSeeding()) {
            return;
        }

        $mailables = MailableTemplates::get();

        foreach ($mailables as $mailable) {
            $mailable = new ReflectionMethod($mailable, 'seed');

            $mailable->invoke(null);
        }
    }
}
