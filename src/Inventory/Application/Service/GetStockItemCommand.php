<?php

namespace App\Inventory\Application\Service;

class GetStockItemCommand
{
    private string $sku;

    public function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}
