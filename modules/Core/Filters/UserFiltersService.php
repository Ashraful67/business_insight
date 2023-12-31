<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Filters;

use Modules\Core\Models\Filter;

class UserFiltersService
{
    public function get(int $userId, string $identifier)
    {
        return Filter::with(['defaults' => fn ($query) => $query->where('user_id', $userId)])
            ->visibleFor($userId)
            ->ofIdentifier($identifier)
            ->orderBy('name')
            ->get();
    }
}
