<?php

namespace App\Cart\Domain\Model\CartItem;

use App\Shared\Domain\Model\SKU;

class CartItem
{
    private SKU $sku;
    private int $quantity;

    /**
     * @param SKU $sku
     * @param int $quantity
     */
    public function __construct(SKU $sku, int $quantity)
    {
        $this->sku = $sku;
        $this->setQuantity($quantity);
    }

    public function changeQuantityTo(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function sku() : SKU
    {
        return $this->sku;
    }

    public function quantity() : int
    {
        return $this->quantity;
    }

    private function setQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidCartItemQuantityException("The quantity for a cart item can not be equal or less than zero.");
        }

        $this->quantity = $quantity;
    }


}
