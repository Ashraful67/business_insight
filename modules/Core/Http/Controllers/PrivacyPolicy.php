<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PrivacyPolicy extends Controller
{
    /**
     * Display the privacy policy.
     */
    public function __invoke(): View
    {
        $content = clean(settings('privacy_policy'));

        return view('core::privacy-policy', compact('content'));
    }
}
