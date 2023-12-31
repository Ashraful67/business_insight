<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Media;

use Modules\Core\Models\PendingMedia;

class PruneStaleMediaAttachments
{
    /**
     * Prune the stale attached media from the system.
     */
    public function __invoke(): void
    {
        PendingMedia::with('attachment')
            ->orderByDesc('id')
            ->where('created_at', '<=', now()->subDays(1))
            ->get()->each->purge();
    }
}
