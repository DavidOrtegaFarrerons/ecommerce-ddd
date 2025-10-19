<?php

namespace App\Inventory\Application\Service;

class UpdateStockItemQuantityCommand
{
    private string $sku;
    private int $quantity;

    public function __construct(string $sku, int $quantity)
    {
        $this->sku = $sku;
        $this->quantity = $quantity;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
