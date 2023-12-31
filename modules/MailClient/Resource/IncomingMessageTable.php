<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Resource;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filters\DateTime as DateTimeFilter;
use Modules\Core\Filters\Radio as RadioFilter;
use Modules\Core\Filters\Text as TextFilter;
use Modules\Core\Resource\Http\ResourceRequest;
use Modules\Core\Table\Column;
use Modules\Core\Table\DateTimeColumn;
use Modules\Core\Table\HasOneColumn;
use Modules\Core\Table\Table;

class IncomingMessageTable extends Table
{
    /**
     * Provides table available default columns
     */
    public function columns(): array
    {
        return [
            Column::make('subject', __('mailclient::inbox.subject')),

            HasOneColumn::make('from', 'address', __('mailclient::inbox.from'))
                ->select('name'),

            DateTimeColumn::make('date', __('mailclient::inbox.date')),
        ];
    }

    /**
     * Get the resource available Filters
     */
    public function filters(ResourceRequest $request): array
    {
        return [
            TextFilter::make('subject', __('mailclient::inbox.subject')),

            TextFilter::make('to', __('mailclient::inbox.to'))->withoutEmptyOperators()
                ->query(function ($builder, $value, $condition, $sqlOperator) {
                    return $builder->whereHas(
                        'from',
                        fn (Builder $query) => $query->where(
                            'address',
                            $sqlOperator['operator'],
                            $value,
                            $condition
                        )->orWhere(
                            'name',
                            $sqlOperator['operator'],
                            $value,
                            $condition
                        )
                    );
                }),

            TextFilter::make('from', __('mailclient::inbox.from'))->withoutEmptyOperators()
                ->query(function ($builder, $value, $condition, $sqlOperator) {
                    return $builder->whereHas(
                        'to',
                        fn (Builder $query) => $query->where(
                            'address',
                            $sqlOperator['operator'],
                            $value,
                            $condition
                        )->orWhere(
                            'name',
                            $sqlOperator['operator'],
                            $value,
                            $condition
                        )
                    );
                }),

            DateTimeFilter::make('date', __('mailclient::inbox.date')),

            RadioFilter::make('is_read', __('mailclient::inbox.filters.is_read'))->options([
                true => __('core::app.yes'),
                false => __('core::app.no'),
            ]),
        ];
    }

    /**
     * Additional fields to be selected with the query
     */
    public function addSelect(): array
    {
        return [
            'is_read',
            'email_account_id', // uri key for json resource
        ];
    }

    /**
     * Boot table
     */
    public function boot(): void
    {
        // Eager load the folders as the folders are used to create the path
        $this->orderBy('date', 'desc')->with('folders');
    }
}
