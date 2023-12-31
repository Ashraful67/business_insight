<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Facades\MailableTemplates;

class MailableTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mailables = MailableTemplates::get();

        foreach ($mailables as $mailable) {
            $mailable = new \ReflectionMethod($mailable, 'seed');

            $mailable->invoke(null);
        }
    }
}
