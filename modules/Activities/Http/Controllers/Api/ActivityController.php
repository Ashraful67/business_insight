<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Http\Controllers\Api;

use Illuminate\Http\Response;
use Modules\Activities\Models\Activity;
use Modules\Core\Http\Controllers\ApiController;

class ActivityController extends ApiController
{
    /**
     * Download ICS of the given activity.
     */
    public function downloadICS(Activity $activity): Response
    {
        $this->authorize('view', $activity);

        return response($activity->generateICSInstance()->get(), 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename='.$activity->icsFilename().'.ics',
            'charset' => 'utf-8',
        ]);
    }
}
