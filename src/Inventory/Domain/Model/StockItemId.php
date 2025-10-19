<?php

namespace App\Inventory\Domain\Model;

use App\Shared\Domain\Model\UuidId;

class StockItemId extends UuidId
{
    public function equalsTo(StockItemId $stockItemId): bool
    {
        return $this->id() === $stockItemId->id();
    }
}
