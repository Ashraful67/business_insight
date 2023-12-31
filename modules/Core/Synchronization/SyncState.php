<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Synchronization;

enum SyncState: string
{
    case DISABLED = 'disabled';
    case STOPPED = 'stopped';
    case ENABLED = 'enabled';
}
