<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Macros\Filesystem;

class DeepCleanDirectory
{
    /**
     * Deep clean the given directory
     *
     * @param  string  $directory
     * @return bool
     */
    public function __invoke($directory)
    {
        if (! is_dir($directory)) {
            return false;
        }

        if (substr($directory, strlen($directory) - 1, 1) != '/') {
            $directory .= '/';
        }

        $items = glob($directory.'*', GLOB_MARK);

        foreach ($items as $item) {
            if (is_dir($item)) {
                (new static())($item);
            } else {
                unlink($item);
            }
        }

        return @rmdir($directory);
    }
}
