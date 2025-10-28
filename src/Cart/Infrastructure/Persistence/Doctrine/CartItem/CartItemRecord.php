<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\CartItem;

use App\Cart\Infrastructure\Persistence\Doctrine\Cart\CartRecord;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(
    name: 'cart_item',
    uniqueConstraints: [new ORM\UniqueConstraint(name: 'uniq_cart_sku', columns: ['cart_id', 'sku'])]
)]
class CartItemRecord
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public string $id;

    #[ORM\ManyToOne(targetEntity: CartRecord::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'cart_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    public CartRecord $cart;

    #[ORM\Column(type: 'string', length: 50)]
    public string $sku;

    #[ORM\Column(type: 'integer')]
    public int $quantity;

    public function setCart(CartRecord $cart): void
    {
        $this->cart = $cart;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}
