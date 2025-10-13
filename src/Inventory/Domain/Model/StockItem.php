<?php

namespace App\Inventory\Domain\Model;

use App\Shared\Domain\Model\SKU;

class StockItem
{
    private StockItemId $id;
    private SKU $sku;
    private StockQuantity $quantity;

    /**
     * @param StockItemId $id
     * @param SKU $sku
     * @param StockQuantity $quantity
     */
    public function __construct(StockItemId $id, SKU $sku, StockQuantity $quantity)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->quantity = $quantity;
    }

    public function adjustStockBy(int $amount) : void
    {
        $this->quantity = $this->quantity->adjustBy($amount);
    }

    public function increaseStockBy(int $amount) : void
    {
        $this->quantity = $this->quantity->increaseBy($amount);
    }

    public function decreaseStockBy(int $amount) : void
    {
        $this->quantity = $this->quantity->decreaseBy($amount);
    }

    public function id() : StockItemId
    {
        return $this->id;
    }

    public function sku() : SKU
    {
        return $this->sku;
    }

    public function quantity() : StockQuantity
    {
        return $this->quantity;
    }
}
