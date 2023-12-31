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
use Modules\Users\Http\Resources\UserResource;
use Modules\Users\Models\User;
use Modules\Users\Services\UserAvatarService;

class UserAvatarController extends ApiController
{
    /**
     * Upload user avatar.
     */
    public function store(Request $request, UserAvatarService $service): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|max:1024',
        ]);

        $user = $service->store($request->user(), $request->file('avatar'));

        return $this->response(new UserResource(
            User::withCommon()->find($user->id)
        ));
    }

    /**
     * Delete the user avatar.
     */
    public function delete(Request $request, UserAvatarService $service): JsonResponse
    {
        $user = $request->user();

        $service::remove($user);

        $user->fill(['avatar' => null])->save();

        return $this->response(new UserResource(
            User::withCommon()->find($user->id)
        ));
    }
}
