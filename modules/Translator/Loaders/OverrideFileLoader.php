<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Translator\Loaders;

use Modules\Translator\Contracts\TranslationLoader;

class OverrideFileLoader implements TranslationLoader
{
    /**
     * Create new OverrideFileLoader instance
     */
    public function __construct(protected string $overridePath)
    {
    }

    /**
     * Get the override path
     */
    public function getOverridePath(): string
    {
        return $this->overridePath;
    }

    /**
     * Returns all translations for the given locale and group.
     */
    public function loadTranslations(string $locale, string $group, ?string $namespace = null): array
    {
        $localePath = $this->overridePath.DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR;

        if (! $namespace || $namespace === '*') {
            $groupPath = $localePath.$group.'.php';
        } else {
            $groupPath = $localePath.'_'.$namespace.DIRECTORY_SEPARATOR.$group.'.php';
        }

        if (file_exists($groupPath)) {
            $translations = include $groupPath;
        }

        return $translations ?? [];
    }
}
