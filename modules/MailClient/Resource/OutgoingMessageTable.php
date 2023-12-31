<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Resource;

use Modules\Core\Table\Column;
use Modules\Core\Table\DateTimeColumn;
use Modules\Core\Table\HasManyColumn;

class OutgoingMessageTable extends IncomingMessageTable
{
    /**
     * Provides table available default columns
     */
    public function columns(): array
    {
        return [
            Column::make('subject', __('mailclient::inbox.subject')),

            HasManyColumn::make('to', 'address', __('mailclient::inbox.to'))
                ->select('name'),

            DateTimeColumn::make('date', __('mailclient::inbox.date')),
        ];
    }
}
