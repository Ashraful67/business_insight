<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Filters;

use Illuminate\Support\Facades\Auth;
use Modules\Core\Filters\Select;
use Modules\Users\Models\User;

class UserFilter extends Select
{
    /**
     * Initialize User class
     *
     * @param  string|null  $label
     * @param  string|null  $field
     */
    public function __construct($label = null, $field = null)
    {
        parent::__construct($field ?? 'user_id', $label ?? __('users::user.user'));

        $this->withNullOperators()
            ->valueKey('id')
            ->labelKey('name');
    }

    /**
     * Provides the User instance options
     *
     * @return \Illuminate\Support\Collection
     */
    public function resolveOptions()
    {
        return User::select(['id', 'name'])
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                $isLoggedInUser = $user->is(Auth::user());

                return [
                    'id' => ! $isLoggedInUser ? $user->id : 'me',
                    'name' => ! $isLoggedInUser ? $user->name : __('core::filters.me'),
                ];
            });
    }
}
