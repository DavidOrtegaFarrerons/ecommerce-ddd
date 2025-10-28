<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\Cart;

use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\Cart\CartId;
use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCartRepository implements CartRepository
{


    public function __construct(
        private EntityManagerInterface $em,
        private CartMapper $mapper
    )
    {
    }

    public function nextIdentity(): CartId
    {
        return CartId::create();
    }

    public function add(Cart $cart)
    {
        $record = $this->mapper->toRecord($cart);
        $this->em->persist($record);
        $this->em->flush();
    }

    public function remove(Cart $cart)
    {
        $record = $this->mapper->toRecord($cart);
        $this->em->remove($record);
        $this->em->flush();
    }

    public function ofUserId(UserId $userId): ?Cart
    {
        $cart = $this->em->getRepository(CartRecord::class)->findOneBy([
            'userId' => $userId->id(),
        ]);

        return $cart !== null ? $this->mapper->toDomain($cart) : null;
    }
}
