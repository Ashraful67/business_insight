<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Modules\Core\Facades\Innoclapps;

class FinalizeUpdateController extends Controller
{
    /**
     * Show the update finalization action.
     */
    public function show(): View
    {
        abort_unless(Innoclapps::requiresUpdateFinalization(), 404);

        return view('core::update.finalize');
    }

    /**
     * Perform update finalization.
     */
    public function finalize(): void
    {
        abort_unless(Innoclapps::requiresUpdateFinalization(), 404);

        Artisan::call('updater:finalize');
    }
}
