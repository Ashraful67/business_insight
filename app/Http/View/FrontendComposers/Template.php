<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace App\Http\View\FrontendComposers;

use JsonSerializable;

class Template implements JsonSerializable
{
    /**
     * @var \App\Http\View\FrontendComposers\Component|null
     */
    public ?Component $viewComponent = null;

    /**
     * Set the view component instance.
     */
    public function viewComponent(Component $component): static
    {
        $this->viewComponent = $component;

        return $this;
    }

    /**
     * Prepare the template for front-end
     */
    public function jsonSerialize(): array
    {
        return [
            'view' => $this->viewComponent,
        ];
    }
}
