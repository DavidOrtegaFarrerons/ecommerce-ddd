<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\CartItem;

use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\CartItem\CartItem;
use App\Cart\Infrastructure\Persistence\Doctrine\Cart\CartRecord;
use App\Shared\Domain\Model\SKU;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class CartItemMapper
{


    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function toRecord(CartRecord $cartRecord, CartItem $cartItem) : CartItemRecord
    {
        $record = $this->em->getRepository(CartItemRecord::class)->findOneBy([
            'cart' => $cartRecord,
            'sku' => $cartItem->sku()->value()
        ]);

        if ($record === null) {
            $record = new CartItemRecord();
            $record->id = Uuid::v4()->toString();
            $record->cart = $cartRecord;
            $record->sku = $cartItem->sku()->value();
        }

        $record->quantity = $cartItem->quantity();

        return $record;
    }

    public function toDomain(CartItemRecord $record): CartItem
    {
        return new CartItem(
            SKU::create($record->sku),
            $record->quantity
        );
    }
}
