<?php

namespace App\Inventory\Application\Transformer;

use App\Inventory\Application\View\StockItemView;
use App\Inventory\Domain\Model\StockItem;

class StockItemViewTransformer
{
    public static function fromDomain(StockItem $stockItem): StockItemView
    {
        return new StockItemView(
            $stockItem->sku()->value(),
            $stockItem->quantity()->value()
        );
    }
}
