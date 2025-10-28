<?php

namespace App\Cart\Application\Service;

class RemoveItemFromCartCommand
{
    private string $userId;
    private string $sku;

    public function __construct(string $userId, string $sku)
    {
        $this->userId = $userId;
        $this->sku = $sku;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}
