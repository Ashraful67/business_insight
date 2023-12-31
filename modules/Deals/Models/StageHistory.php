<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StageHistory extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'entered_at' => 'datetime',
        'left_at' => 'datetime',
        'deal_id' => 'int',
        'stage_id' => 'int',
    ];
}
