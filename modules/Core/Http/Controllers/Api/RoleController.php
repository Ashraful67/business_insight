<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\RoleRequest;
use Modules\Core\Http\Resources\RoleResource;
use Modules\Core\Models\Role;

class RoleController extends ApiController
{
    /**
     * Display a listing of the roles.
     */
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->orderBy('name')->get();

        return $this->response(RoleResource::collection($roles));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        $role->loadMissing('permissions');

        return $this->response(new RoleResource($role));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(RoleRequest $request): JsonResponse
    {
        $role = Role::create(['name' => $request->name]);

        $role->givePermissionTo($request->input('permissions', []));

        return $this->response(
            new RoleResource($role->loadMissing('permissions')),
            201
        );
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Role $role, RoleRequest $request): JsonResponse
    {
        $role->fill(['name' => $request->name]);

        $role->syncPermissions($request->input('permissions', []));

        return $this->response(new RoleResource($role));
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        return $this->response('', 204);
    }
}
