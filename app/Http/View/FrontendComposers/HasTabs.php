<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Http\View\FrontendComposers;

trait HasTabs
{
    /**
     * Registered tabs.
     */
    protected static array $tabs = [];

    /**
     * Register new tab.
     */
    public static function registerTab(Tab $tab): void
    {
        if (! static::findTab($tab->id)) {
            static::$tabs[] = $tab;
        }
    }

    /**
     * Find tab by given ID.
     */
    public static function findTab(string $id): ?Tab
    {
        foreach (static::$tabs as $registered) {
            if ($registered->id === $id) {
                return $registered;
            }
        }

        return null;
    }

    /**
     * Get the ordered tabs.
     */
    public function orderedTabs(): array
    {
        return collect(static::$tabs)->sortBy('displayOrder')->values()->all();
    }

    /**
     * Register tabs.
     */
    public static function registerTabs(array $tabs): void
    {
        foreach ($tabs as $tab) {
            static::registerTab($tab);
        }
    }
}
