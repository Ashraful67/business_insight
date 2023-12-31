<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

use Modules\Core\Resource\Http\ResourceRequest;

class Domain extends Field
{
    /**
     * Field component
     */
    public ?string $component = 'domain-field';

    /**
     * This field support input group
     */
    public bool $supportsInputGroup = true;

    /**
     * Boot field
     *
     * Sets icon
     *
     * @return null
     */
    public function boot()
    {
        $this->provideSampleValueUsing(fn () => 'example.com')->prependIcon('Globe');
    }

    /**
     * Get the field value for the given request
     *
     * @param  string  $requestAttribute
     */
    public function attributeFromRequest(ResourceRequest $request, $requestAttribute): mixed
    {
        $value = parent::attributeFromRequest($request, $requestAttribute);

        return \Modules\Core\Domain::extractFromUrl($value ?? '');
    }
}
