<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\Cart;

use App\Cart\Infrastructure\Persistence\Doctrine\CartItem\CartItemRecord;
use App\Shared\Domain\Model\Address;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cart')]
class CartRecord
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public string $id;

    #[ORM\Column(type: 'uuid')]
    public string $userId;

    /** @var Collection<int, CartItemRecord> */
    #[ORM\OneToMany(targetEntity: CartItemRecord::class, mappedBy: 'cart', cascade: ['persist', 'remove'], orphanRemoval: true)]
    public Collection $items;

    #[ORM\Embedded(class: Address::class, columnPrefix: 'shipping_')]
    public ?Address $shippingAddress = null;
}
