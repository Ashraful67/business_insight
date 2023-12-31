<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Updater;

use Symfony\Component\Finder\Finder;

trait ChecksPermissions
{
    /**
     * @var callable|null
     */
    protected static $permissionsCheckerFinderUsing;

    /**
     * Check a given directory recursively if all files are writeable.
     */
    protected function checkPermissions(string $path, array $excludedFolders): bool
    {
        $passes = true;
        $finder = $this->getPermissionsCheckerFinderInstance($path, $excludedFolders);

        foreach ($finder as $file) {
            if ($file->isWritable() === false) {
                $passes = false;

                break;
            }
        }

        return $passes;
    }

    /**
     * Get the finder instance for the permissions checker
     */
    protected function getPermissionsCheckerFinderInstance(string $path, array $excludedFolders): Finder
    {
        if (static::$permissionsCheckerFinderUsing) {
            return call_user_func_array(static::$permissionsCheckerFinderUsing, [$path]);
        }

        return (new Finder())->exclude($excludedFolders)->notName('worker.log')->in($path);
    }

    /**
     * Provide custom permissions checker Finder instance
     */
    public static function providePermissionsCheckerFinderUsing(?callable $callback): void
    {
        static::$permissionsCheckerFinderUsing = $callback;
    }
}
