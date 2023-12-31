<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Updater;

trait ExchangesPurchaseKey
{
    protected ?string $purchaseKey = null;

    /**
     * Use the given custom purchase key.
     */
    public function usePurchaseKey(string $key): static
    {
        $this->purchaseKey = $key;

        return $this;
    }

    /**
     * Get the updater purchase key.
     */
    public function getPurchaseKey(): ?string
    {
        return $this->purchaseKey ?: $this->config['purchase_key'];
    }
}
