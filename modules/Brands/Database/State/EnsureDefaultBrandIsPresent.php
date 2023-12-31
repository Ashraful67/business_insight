<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Brands\Database\State;

use Illuminate\Support\Facades\DB;

class EnsureDefaultBrandIsPresent
{
    public function __invoke(): void
    {
        if ($this->present()) {
            return;
        }

        \Modules\Brands\Models\Brand::create([
            'name' => config('app.name'),
            'display_name' => config('app.name'),
            'is_default' => true,
            'config' => [
                'primary_color' => '#4f46e5',
            ],
        ]);
    }

    private function present(): bool
    {
        return DB::table('brands')->where('is_default', true)->count() > 0;
    }
}
