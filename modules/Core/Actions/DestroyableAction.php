<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Actions;

use Illuminate\Support\Collection;

abstract class DestroyableAction extends Action
{
    /**
     * Handle method
     *
     * @return mixed
     */
    public function handle(Collection $models, ActionFields $fields)
    {
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * Action name
     */
    public function name(): string
    {
        return __('core::app.delete');
    }
}
