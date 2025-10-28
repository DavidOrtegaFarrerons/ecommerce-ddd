<?php

namespace App\Cart\Application\View;

use App\Shared\Domain\Model\Money;

final class CartItemView
{
    public function __construct(
        private string $sku,
        private string $name,
        private string $description,
        private string $categoryName,
        private Money $unitPrice,
        private int $quantity,
        private Money $lineTotal,
    ) {
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getLineTotal(): Money
    {
        return $this->lineTotal;
    }
}
