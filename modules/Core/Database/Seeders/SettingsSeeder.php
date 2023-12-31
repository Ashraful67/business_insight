<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Settings\DefaultSettings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        settings()->flush();

        $options = array_merge(DefaultSettings::get(), ['_seeded' => true]);

        foreach ($options as $name => $value) {
            settings()->set([$name => $value]);
        }

        settings()->save();

        config(['mediable.allowed_extensions' => array_map(
            fn ($extension) => trim(str_replace('.', '', $extension)),
            explode(',', settings('allowed_extensions'))
        )]);
    }
}
