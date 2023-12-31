<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastActiveDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $this->updateLastActiveDate();
        }

        return $response;
    }

    /**
     * Update the current user last active date.
     */
    protected function updateLastActiveDate(): void
    {
        User::withoutTimestamps(function () {
            User::where('id', Auth::id())->update([
                'last_active_at' => now(),
            ]);
        });
    }
}
