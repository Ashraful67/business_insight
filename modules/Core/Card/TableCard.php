<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Card;

class TableCard extends Card
{
    /**
     * The primary key for the table row
     */
    protected string $primaryKey = 'id';

    /**
     * Define the card component used on front end
     */
    public function component(): string
    {
        return 'card-table';
    }

    /**
     * Provide the table fields
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Provide the table data
     */
    public function items(): iterable
    {
        return [];
    }

    /**
     * Table empty text
     */
    public function emptyText(): ?string
    {
        return null;
    }

    /**
     * jsonSerialize
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'fields' => $this->fields(),
            'items' => $this->items(),
            'emptyText' => $this->emptyText(),
            'primaryKey' => $this->primaryKey,
        ]);
    }
}
