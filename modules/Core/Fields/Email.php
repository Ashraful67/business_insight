<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Fields;

class Email extends Text
{
    /**
     * Input type
     */
    public string $inputType = 'email';

    /**
     * Boot the field
     *
     * @return void
     */
    public function boot()
    {
        $this->rules(['email', 'nullable'])->prependIcon('Mail')
            ->tapIndexColumn(function ($column) {
                $column->useComponent('table-data-email-column');
            })->provideSampleValueUsing(fn () => uniqid().'@example.com');
    }
}
