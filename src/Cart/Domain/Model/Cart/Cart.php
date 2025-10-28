<?php

namespace App\Cart\Domain\Model\Cart;

use App\Cart\Domain\Model\CartItem\CartItem;
use App\Identity\Domain\Model\UserId;
use App\Shared\Domain\Model\Address;
use App\Shared\Domain\Model\SKU;

class Cart
{
    private CartId $id;
    private UserId $userId;

    /**
     * @var CartItem[]
     */
    private array $items;
    private ?Address $shippingAddress = null;

    /**
     * @param CartItem[] $items
     */
    public function __construct(CartId $id, UserId $userId, array $items, ?Address $shippingAddress = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->items = $items;
        $this->shippingAddress = $shippingAddress;
    }

    public function addItem(CartItem $newItem): void
    {
        foreach ($this->items as $item) {
            if ($newItem->sku()->equalsTo($item->sku())) {
                $item->changeQuantityTo($item->quantity());

                return;
            }
        }

        $this->items[] = $newItem;
    }

    public function removeItem(SKU $itemToRemove): void
    {
        foreach ($this->items as $key => $item) {
            if ($itemToRemove->equalsTo($item->sku())) {
                unset($this->items[$key]);

                return;
            }
        }
    }

    public function updateItemQuantity(SKU $sku, int $quantity): void
    {
        foreach ($this->items as $item) {
            if ($sku->equalsTo($item->sku())) {
                $item->changeQuantityTo($quantity);
            }
        }
    }

    public function changeShippingAddressTo(Address $newAddress): void
    {
        $this->shippingAddress = $newAddress;
    }

    public function id(): CartId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function shippingAddress(): ?Address
    {
        return $this->shippingAddress;
    }
}
