<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Broadcast;
use Modules\Deals\Models\Deal;

Broadcast::channel('Modules.Deals.Models.Deal.{dealId}', function ($user, $dealId) {
    return $user->can('view', Deal::findOrFail($dealId));
});
