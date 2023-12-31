<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api\Resource;

use Modules\Core\Actions\ActionRequest;
use Modules\Core\Http\Controllers\ApiController;

class ActionController extends ApiController
{
    /**
     * Run resource action.
     */
    public function handle($action, ActionRequest $request): mixed
    {
        $request->validateFields();

        return $request->run();
    }
}
