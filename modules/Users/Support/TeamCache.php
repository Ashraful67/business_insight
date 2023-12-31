<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Support;

use Illuminate\Support\Arr;
use Modules\Users\Models\User;

class TeamCache
{
    protected static ?array $usersTeams = null;

    public static function userManagesAnyTeamsOf(int $userId, int $ofUserId): bool
    {
        static::cacheUserTeams();

        return in_array($userId, static::$usersTeams[$ofUserId]);
    }

    public static function flush(): void
    {
        static::$usersTeams = null;
    }

    protected static function cacheUserTeams(): void
    {
        if (! static::$usersTeams) {
            static::$usersTeams = User::with(['teams' => function ($query) {
                $query->select(['teams.user_id']);
            }])
                ->get(['id'])
                ->mapWithKeys(function ($user) {
                    return [$user->id => Arr::pluck($user->teams, 'user_id')];
                })->all();
        }
    }
}
