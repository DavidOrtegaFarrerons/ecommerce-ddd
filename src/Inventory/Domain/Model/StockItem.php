<?php

namespace App\Inventory\Domain\Model;

use App\Shared\Domain\Model\SKU;

class StockItem
{
    private StockItemId $id;
    private SKU $sku;
    private StockQuantity $quantity;

    public function __construct(StockItemId $id, SKU $sku, StockQuantity $quantity)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->quantity = $quantity;
    }

    public function setStockTo(StockQuantity $stock): void
    {
        $this->quantity = $stock;
    }

    public function id(): StockItemId
    {
        return $this->id;
    }

    public function sku(): SKU
    {
        return $this->sku;
    }

    public function quantity(): StockQuantity
    {
        return $this->quantity;
    }
}
