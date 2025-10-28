<?php

namespace App\Cart\Infrastructure\Persistence\Doctrine\CartItem;

use App\Cart\Domain\Model\Cart\CartId;
use App\Cart\Domain\Model\CartItem\CartItem;
use App\Cart\Domain\Model\CartItem\CartItemRepository;
use App\Shared\Domain\Model\SKU;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCartItemRepository implements CartItemRepository
{


    public function __construct(private EntityManagerInterface $em)
    {
    }

}
