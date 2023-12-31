<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\VisibilityGroup;

use Illuminate\Database\Eloquent\Builder;
use Modules\Users\Models\User;

interface HasVisibilityGroups
{
    public function isVisible(User $user): bool;

    public function scopeVisible(Builder $query, User $user): void;
}
