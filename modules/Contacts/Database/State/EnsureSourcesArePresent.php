<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Database\State;

use Illuminate\Support\Facades\DB;

class EnsureSourcesArePresent
{
    public array $sources = [
        'Organic search',
        'Paid search',
        'Email marketing',
        'Social media',
        'Referrals',
        'Other campaigns',
        'Direct traffic',
        'Offline Source',
        'Paid social',
        'Web Form',
    ];

    public function __invoke(): void
    {
        if ($this->present()) {
            return;
        }

        foreach ($this->sources as $source) {
            \Modules\Contacts\Models\Source::create([
                'name' => $source,
                'flag' => $source === 'Web Form' ? 'web-form' : null,
            ]);
        }
    }

    private function present(): bool
    {
        return DB::table('sources')->count() > 0;
    }
}
