<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Support;

use Illuminate\Support\Facades\Http;

class License
{
    /**
     * Verify the given license
     *
     * @param  string  $key
     * @return bool
     */
    public static function verify($key)
    {
        $response = Http::withHeaders([
            'X-Concord-Installation' => true,
        ])
            ->contentType('application/json')
            ->get('https://www.concordcrm.com/verify-license/'.$key);

        if ($response->successful()) {
            return $response['valid'];
        }

        return false;
    }
}
