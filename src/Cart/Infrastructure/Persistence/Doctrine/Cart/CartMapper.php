<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\Cart;

use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\Cart\CartId;
use App\Cart\Infrastructure\Persistence\Doctrine\CartItem\CartItemMapper;
use App\Cart\Infrastructure\Persistence\Doctrine\CartItem\CartItemRecord;
use App\Identity\Domain\Model\UserId;
use App\Shared\Domain\Model\Address;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class CartMapper
{
    public function __construct(
        private EntityManagerInterface $em,
        private CartItemMapper $itemMapper,
    ) {
    }

    public function toRecord(Cart $cart): CartRecord
    {
        $record = $this->em->getRepository(CartRecord::class)->findOneBy([
            'userId' => $cart->userId()->id(),
        ]);

        if (null === $record) {
            $record = new CartRecord();
            $record->id = $cart->id()->id();
            $record->userId = $cart->userId()->id();
            $record->items = new ArrayCollection();
        }

        $record->shippingAddress = $cart->shippingAddress();

        foreach ($record->items as $existingItem) {
            $this->em->remove($existingItem);
        }
        $record->items->clear();

        foreach ($cart->items() as $cartItem) {
            $recordItem = $this->itemMapper->toRecord($record, $cartItem);
            $record->items->add($recordItem);
            $this->em->persist($recordItem);
        }

        return $record;
    }

    public function toDomain(CartRecord $cartRecord): Cart
    {
        return new Cart(
            CartId::create($cartRecord->id),
            UserId::create($cartRecord->userId),
            array_map(function (CartItemRecord $cartRecord) {
                return $this->itemMapper->toDomain($cartRecord);
            }, $cartRecord->items->toArray()),
            Address::create(
                $cartRecord->shippingAddress->street(),
                $cartRecord->shippingAddress->city(),
                $cartRecord->shippingAddress->postalCode(),
                $cartRecord->shippingAddress->country()
            )
        );
    }
}
