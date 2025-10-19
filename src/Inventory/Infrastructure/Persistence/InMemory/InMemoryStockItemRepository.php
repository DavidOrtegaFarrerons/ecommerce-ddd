<?php

namespace App\Inventory\Infrastructure\Persistence\InMemory;

use App\Inventory\Domain\Model\StockItem;
use App\Inventory\Domain\Model\StockItemId;
use App\Inventory\Domain\Model\StockItemRepository;
use App\Shared\Domain\Model\SKU;

class InMemoryStockItemRepository implements StockItemRepository
{
    private $stockItems = [];

    public function nextIdentity(): StockItemId
    {
        return StockItemId::create();
    }

    public function add(StockItem $stockItem)
    {
        $this->stockItems[$stockItem->id()->id()] = $stockItem;
    }

    public function remove(StockItem $stockItem)
    {
        unset($this->stockItems[$stockItem->id()->id()]);
    }

    public function ofId(StockItemId $stockItemId): ?StockItem
    {
        if (isset($this->stockItems[$stockItemId->id()])) {
            return $this->stockItems[$stockItemId->id()];
        }

        return null;
    }

    public function ofSku(SKU $sku): ?StockItem
    {
        foreach ($this->stockItems as $stockItem) {
            if ($stockItem->sku()->equalsTo($sku)) {
                return $stockItem;
            }
        }

        return null;
    }
}
