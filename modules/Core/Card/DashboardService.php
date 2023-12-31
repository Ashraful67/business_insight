<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Card;

use Modules\Core\Models\Dashboard;
use Modules\Users\Models\User;

class DashboardService
{
    /**
     * Create new dashboard for the given user.
     */
    public function create(array $attributes, int $userId): Dashboard
    {
        $attributes['user_id'] = $userId;
        $attributes['is_default'] ??= false;
        $attributes['cards'] ??= Dashboard::defaultCards(User::find($userId));

        $dashboard = new Dashboard;
        $dashboard->fill($attributes)->save();

        if ($dashboard->is_default) {
            Dashboard::where('id', '!=', $dashboard->id)->update(['is_default' => false]);
        }

        return $dashboard;
    }

    /**
     * Create default dashboard for the given user.
     */
    public function createDefault(User $user): Dashboard
    {
        return $this->create(['name' => 'Application Dashboard', 'is_default' => true], $user->id);
    }
}
