<?php

namespace App\Order\Domain\Model;

use App\Shared\Domain\Model\UuidId;

class OrderId extends UuidId
{
    public function equalsTo(OrderId $orderId): bool
    {
        return $this->id() === $orderId->id();
    }
}
