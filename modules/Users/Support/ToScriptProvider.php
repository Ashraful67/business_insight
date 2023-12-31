<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Support;

use Illuminate\Support\Facades\Auth;
use Modules\Users\Http\Resources\UserResource;
use Modules\Users\Models\User;

class ToScriptProvider
{
    /**
     * Provide the data to script.
     */
    public function __invoke(): array
    {
        if (! Auth::check()) {
            return [];
        }

        return [
            'user_id' => Auth::id(),
            'users' => UserResource::collection(User::withCommon()->get()),
            'invitation' => [
                'expires_after' => config('users.invitation.expires_after'),
            ],
        ];
    }
}
