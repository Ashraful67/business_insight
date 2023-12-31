<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class AbstractMask implements JsonSerializable, Arrayable
{
    /**
     * Initialize the mask
     *
     * @param  array|object  $entity
     */
    public function __construct(protected $entity)
    {
    }

    /**
     * Get the entity
     *
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
