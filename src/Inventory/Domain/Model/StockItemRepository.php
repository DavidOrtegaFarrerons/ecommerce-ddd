<?php

namespace App\Inventory\Domain\Model;

use App\Shared\Domain\Model\SKU;

interface StockItemRepository
{
    public function nextIdentity() : StockItemId;
    public function add(StockItem $stockItem);
    public function remove(StockItem $stockItem);
    public function ofId(StockItemId $stockItemId): ?StockItem;
    public function ofSku(Sku $sku): ?StockItem;

}
