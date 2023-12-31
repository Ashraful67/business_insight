<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Updater\Events;

use Modules\Core\Updater\Release;

class UpdateSucceeded
{
    /**
     * Initialize new UpdateSucceeded instance.
     */
    public function __construct(protected Release $release)
    {
    }

    /**
     * Get the new version.
     */
    public function getVersionUpdatedTo(): string
    {
        return $this->release->getVersion();
    }
}
