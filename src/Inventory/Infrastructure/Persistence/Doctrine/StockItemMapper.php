<?php

namespace App\Inventory\Infrastructure\Persistence\Doctrine;

use App\Inventory\Domain\Model\StockItem;
use App\Inventory\Domain\Model\StockItemId;
use App\Inventory\Domain\Model\StockQuantity;
use App\Shared\Domain\Model\SKU;

class StockItemMapper
{
    public static function toRecord(StockItem $stockItem) : StockItemRecord
    {
        $r = new StockItemRecord();
        $r->id = $stockItem->id()->id();
        $r->sku = $stockItem->sku()->value();
        $r->quantity = $stockItem->quantity()->value();

        return $r;
    }

    public static function toDomain(StockItemRecord $stockItemRecord): StockItem
    {
        return new StockItem(
            StockItemId::create($stockItemRecord->id),
            SKU::create($stockItemRecord->sku),
            StockQuantity::create($stockItemRecord->quantity)
        );
    }
}
