<?php

namespace App\Catalog\Domain;

use App\Shared\Domain\UuidId;

class ProductId extends UuidId {
    public function equalsTo(ProductId $productId): bool
    {
        return $this->id() === $productId->id();
    }
}
