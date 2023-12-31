<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ApplicationController extends Controller
{
    /**
     * Application main view.
     */
    public function __invoke(): View
    {
        return view('core::app');
    }
}
