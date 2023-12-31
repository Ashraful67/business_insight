<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Highlights;

class Highlights
{
    /**
     * @var array<Highlight>
     */
    protected static array $highlights = [];

    /**
     * Get all the highlights.
     *
     * @return array<Highlight>
     */
    public static function get(): array
    {
        return array_values(static::$highlights);
    }

    /**
     * Register new highlight.
     *
     * @param  Highlight|array<Highlight>  $highlights
     */
    public static function register(Highlight|array $highlights): static
    {
        if (! is_array($highlights)) {
            $highlights = [$highlights];
        }

        foreach ($highlights as $highlight) {
            if (! $highlight instanceof Highlight) {
                $highlight = new $highlight;
            }

            static::$highlights[$highlight->name()] = $highlight;
        }

        return new static;
    }
}
