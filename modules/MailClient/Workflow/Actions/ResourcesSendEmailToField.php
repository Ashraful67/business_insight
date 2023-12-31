<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Workflow\Actions;

use Modules\Core\Facades\Innoclapps;
use Modules\Core\Fields\Select;

class ResourcesSendEmailToField extends Select
{
    /**
     * Initialize new ResourcesSendEmailToField field
     */
    public function __construct()
    {
        parent::__construct('to');

        $this->rules('required')->withMeta([
            'attributes' => [
                'placeholder' => __('mailclient::mail.workflows.fields.to'),
            ], ]);
    }

    /**
     * Get the available resources from the field.
     */
    public function getToResources(): array
    {
        return collect($this->options)->mapWithKeys(function ($option, $key) {
            return [$key => Innoclapps::resourceByName($option['resource'])];
        })->all();
    }

    /**
     * Resolve the field options
     *
     * @return array
     */
    public function resolveOptions()
    {
        return collect(parent::resolveOptions())->map(function ($option) {
            return [
                $this->labelKey => $option['label']['label'],
                $this->valueKey => $option['value'],
            ];
        })->all();
    }
}
