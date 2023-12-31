<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Client\Outlook;

use Illuminate\Support\Collection;

class DeltaMessageCollection extends Collection
{
    protected static ?string $deltaLink;

    public function setDeltaLink(?string $link): static
    {
        static::$deltaLink = $link;

        return $this;
    }

    public static function getDeltaLink(): ?string
    {
        return static::$deltaLink;
    }
}
