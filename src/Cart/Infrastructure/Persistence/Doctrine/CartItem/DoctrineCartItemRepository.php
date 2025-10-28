<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\CartItem;

use App\Cart\Domain\Model\CartItem\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCartItemRepository implements CartItemRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
}
