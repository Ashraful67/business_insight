<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\LogReader;
use Modules\Core\SystemInfo;

class SystemController extends ApiController
{
    /**
     * Get the system info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        // System info flag

        return $this->response(new SystemInfo(Request::instance()));
    }

    /**
     * Download the system info
     *
     * @return mixed
     */
    public function downloadInfo()
    {
        // System info download flag

        return Excel::download(new SystemInfo(Request::instance()), 'system-info.xlsx');
    }

    /**
     * Get the application/Laravel logs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs()
    {
        // System logs flag

        return $this->response(
            (new LogReader(['date' => Request::instance()->date]))->get()
        );
    }
}
