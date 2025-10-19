<?php

namespace App\Catalog\Domain\Event;

use App\Catalog\Domain\Model\Product\ProductId;
use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Model\SKU;

class ProductCreated implements DomainEvent
{
    private SKU $sku;
    private \DateTimeImmutable $ocurredOn;

    /**
     * @param SKU $sku
     * @param \DateTimeImmutable $ocurredOn
     */
    public function __construct(SKU $sku, \DateTimeImmutable $ocurredOn = new \DateTimeImmutable())
    {
        $this->sku = $sku;
        $this->ocurredOn = $ocurredOn;
    }

    public function sku(): SKU
    {
        return $this->sku;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->ocurredOn;
    }
}
