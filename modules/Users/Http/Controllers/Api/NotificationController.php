<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiController;

class NotificationController extends ApiController
{
    /**
     * List current user notifications
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response(
            $request->user()->notifications()->paginate($request->integer('per_page', 15))
        );
    }

    /**
     * Retrieve current user notification
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Request $request)
    {
        return $this->response(
            $request->user()->notifications()->findOrFail($id)
        );
    }

    /**
     * Set all notifications for current user as read
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return $this->response('', 204);
    }

    /**
     * Delete current user notification
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        $request->user()
            ->notifications()
            ->findOrFail($id)
            ->delete();

        return $this->response('', 204);
    }
}
