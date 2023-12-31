<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Cards;

use Modules\Core\Card\TableCard;
use Modules\Core\Date\Carbon;
use Modules\Deals\Criteria\ViewAuthorizedDealsCriteria;
use Modules\Deals\Models\Deal;

class RecentlyModifiedDeals extends TableCard
{
    /**
     * Limit the number of records shown in the table
     *
     * @var int
     */
    protected $limit = 20;

    /**
     * Created in the last 30 days
     *
     * @var int
     */
    protected $days = 30;

    /**
     * Provide the table items
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function items(): iterable
    {
        return Deal::select(['id', 'name', 'updated_at', 'stage_id'])
            ->criteria(ViewAuthorizedDealsCriteria::class)
            ->with('stage')
            ->where('updated_at', '>', Carbon::asCurrentTimezone()->subDays($this->days)->inAppTimezone())
            ->orderBy('updated_at', 'desc')
            ->limit($this->limit)
            ->get()
            ->map(function ($deal) {
                return [
                    'id' => $deal->id,
                    'name' => $deal->name,
                    'stage' => $deal->stage,
                    'updated_at' => $deal->updated_at,
                    'path' => $deal->path,
                ];
            });
    }

    /**
     * Provide the table fields
     */
    public function fields(): array
    {
        return [
            ['key' => 'name', 'label' => __('deals::fields.deals.name')],
            ['key' => 'stage.name', 'label' => __('deals::fields.deals.stage.name')],
            ['key' => 'updated_at', 'label' => __('core::app.updated_at')],
        ];
    }

    /**
     * Card title
     */
    public function name(): string
    {
        return __('deals::deal.cards.recently_modified');
    }

    /**
     * jsonSerialize
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'help' => __('deals::deal.cards.recently_modified_info', ['total' => $this->limit, 'days' => $this->days]),
        ]);
    }
}
