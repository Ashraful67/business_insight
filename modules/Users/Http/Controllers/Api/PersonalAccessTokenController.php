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

class PersonalAccessTokenController extends ApiController
{
    /**
     * Get all user personal access tokens.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->response($request->user()->tokens);
    }

    /**
     * Create new user personal access token.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        return $this->response($request->user()->createToken(
            $request->name
        ), 201);
    }

    /**
     * Revoke the given user personal access token.
     */
    public function destroy(string $id, Request $request): JsonResponse
    {
        $token = $request->user()->tokens()->find($id);

        abort_if(is_null($token), 404);

        $token->delete();

        return $this->response('', 204);
    }
}
