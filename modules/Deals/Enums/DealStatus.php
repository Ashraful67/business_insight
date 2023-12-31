<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Enums;

use Modules\Core\InteractsWithEnums;

enum DealStatus: int
{
    use InteractsWithEnums;

    case open = 1;
    case won = 2;
    case lost = 3;

    /**
     * Get the deal status badge variant.
     */
    public function badgeVariant(): string
    {
        return static::badgeVariants()[$this->name];
    }

    /**
     * Get the available badge variants.
     */
    public static function badgeVariants(): array
    {
        return [
            DealStatus::open->name => 'neutral',
            DealStatus::won->name => 'success',
            DealStatus::lost->name => 'danger',
        ];
    }
}
