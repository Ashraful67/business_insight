<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\ZapierHook;

class ZapierHookController extends ApiController
{
    /**
     * Subscribe to a hook.
     */
    public function store(string $resourceName, string $action, Request $request): JsonResponse
    {
        $hook = new ZapierHook([
            'hook' => $request->targetUrl,
            'resource_name' => $resourceName,
            'action' => $action,
            'user_id' => $request->user()->id,
            // Needs further testing, previously the zapId was only numeric
            // but now includes subscriptions:zapId
            'zap_id' => str_contains($request->zapId, 'subscription:') ?
                explode('subscription:', $request->zapId)[1] :
                $request->zapId,
            'data' => $request->data,
        ]);

        $hook->save();

        return $this->response($hook, 201);
    }

    /**
     * Unsubscribe from hook.
     */
    public function destroy(string $id, Request $request): JsonResponse
    {
        ZapierHook::where('user_id', $request->user()->getKey())->findOrFail($id)->delete();

        return $this->response('', 204);
    }
}
