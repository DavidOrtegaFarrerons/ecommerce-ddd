<?php

namespace App\Catalog\Domain\Model\Product;

use App\Shared\Domain\Model\UuidId;

class ProductId extends UuidId {
    public function equalsTo(ProductId $productId): bool
    {
        return $this->id() === $productId->id();
    }
}
