<?php

namespace App\Cart\Application\Service;

class UpdateCartItemQuantityCommand
{
    private string $userId;
    private string $sku;
    private int $quantity;

    public function __construct(string $userId, string $sku, int $quantity)
    {
        $this->userId = $userId;
        $this->sku = $sku;
        $this->quantity = $quantity;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
