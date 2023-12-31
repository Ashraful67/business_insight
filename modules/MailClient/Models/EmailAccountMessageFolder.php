<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmailAccountMessageFolder extends Pivot
{
    /**
     * Indicates if the model has timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'message_id' => 'int',
        'folder_id' => 'int',
    ];
}
