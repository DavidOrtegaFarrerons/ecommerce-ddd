<?php

namespace App\Cart\Domain\Model\Cart;

use App\Shared\Domain\Model\UuidId;

class CartId extends UuidId
{
    public function equalsTo(CartId $cartId): bool
    {
        return $this->id() === $cartId->id();
    }
}
