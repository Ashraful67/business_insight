<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Database\State;

use Modules\Core\Settings\DefaultSettings;

class EnsureDefaultSettingsArePresent
{
    public function __invoke(): void
    {
        if ($this->present()) {
            return;
        }

        settings()->flush();

        $settings = array_merge(DefaultSettings::get(), ['_seeded' => true]);

        foreach ($settings as $setting => $value) {
            settings()->set([$setting => $value]);
        }

        settings()->save();

        config(['mediable.allowed_extensions' => array_map(
            fn ($extension) => trim(str_replace('.', '', $extension)),
            explode(',', settings('allowed_extensions'))
        )]);
    }

    private function present(): bool
    {
        return settings('_seeded') === true;
    }
}
