<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\SettingRequest;

class SettingsController extends ApiController
{
    /**
     * Get the application settings.
     */
    public function index(): JsonResponse
    {
        return $this->response(
            collect(settings()->all())->reject(fn ($value, $name) => Str::startsWith($name, '_'))
        );
    }

    /**
     * Persist the settings in storage.
     */
    public function save(SettingRequest $request): JsonResponse
    {
        $request->saveSettings();

        return $this->response(settings()->all());
    }
}
