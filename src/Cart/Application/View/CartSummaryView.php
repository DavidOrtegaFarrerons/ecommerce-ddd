<?php

namespace App\Cart\Application\View;

use App\Shared\Domain\Model\Address;
use App\Shared\Domain\Model\Money;

class CartSummaryView
{
    private Address $shippingAddress;
    /**
     * @var CartItemView[]
     */
    private array $cartItemsViews;
    private Money $total;

    /**
     * @param Address $shippingAddress
     * @param CartItemView[] $cartItemsViews
     * @param Money $total
     */
    public function __construct(Address $shippingAddress, array $cartItemsViews, Money $total)
    {
        $this->shippingAddress = $shippingAddress;
        $this->cartItemsViews = $cartItemsViews;
        $this->total = $total;
    }

    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    public function getCartItemsViews(): array
    {
        return $this->cartItemsViews;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }
}
