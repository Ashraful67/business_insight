<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Activities\Support;

use Illuminate\Support\Facades\Auth;
use Modules\Activities\Http\Resources\ActivityTypeResource;
use Modules\Activities\Models\ActivityType;

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
            'defaults' => config('activities.defaults'),
            'activities' => [
                'default_activity_type_id' => ActivityType::getDefaultType(),

                'types' => ActivityTypeResource::collection(
                    ActivityType::withCommon()->orderBy('name')->get()
                ),
            ]];
    }
}
