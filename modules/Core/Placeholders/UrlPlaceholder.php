<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Placeholders;

use Modules\Core\Contracts\Presentable;

class UrlPlaceholder extends Placeholder
{
    /**
     * Initialize new UrlPlaceholder instance.
     *
     * @param  \Closure|mixed  $value
     */
    public function __construct($value = null, string $tag = 'url')
    {
        parent::__construct($tag, $value);

        $this->description('URL');
    }

    /**
     * Format the placeholder
     *
     * @return string
     */
    public function format(?string $contentType = null)
    {
        return url(
            $this->value instanceof Presentable ? $this->value->path : $this->value
        );
    }
}
