<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Fields;

use Modules\Contacts\Http\Resources\CompanyResource;
use Modules\Contacts\Models\Company as CompanyModel;
use Modules\Core\Fields\BelongsTo;

class Company extends BelongsTo
{
    /**
     * Create new instance of Company field
     *
     * @param  string  $relationName The relation name, snake case format
     * @param  string  $label Custom label
     * @param  string  $foreignKey Custom foreign key
     */
    public function __construct($relationName = 'company', $label = null, $foreignKey = null)
    {
        parent::__construct($relationName, CompanyModel::class, $label ?? __('contacts::company.company'), $foreignKey);

        $this->setJsonResource(CompanyResource::class)
            ->async('/companies/search');
    }
}
