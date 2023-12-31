<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Users\Http\Requests\PasswordRequest;
use Modules\Users\Http\Requests\ProfileRequest;
use Modules\Users\Http\Resources\UserResource;
use Modules\Users\Models\User;
use Modules\Users\Services\UserService;

class ProfileController extends ApiController
{
    /**
     * Get user.
     */
    public function show(Request $request): JsonResponse
    {
        return $this->response(new UserResource(
            User::withCommon()->find($request->user()->id)
        ));
    }

    /**
     * Update profile.
     */
    public function update(ProfileRequest $request, UserService $service): JsonResponse
    {
        // Profile update flag

        $user = $service->update(
            $request->user(),
            $request->except(['super_admin', 'access_api']),
        );

        return $this->response(new UserResource(
            User::withCommon()->find($user->id)
        ));
    }

    /**
     * Change password.
     */
    public function password(PasswordRequest $request, UserService $service): JsonResponse
    {
        // Profile update password flag
        $service->update(
            $request->user(),
            ['password' => $request->get('password')],
        );

        return $this->response('', 204);
    }
}
