<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\Cart\CartRepository;
use App\Cart\Domain\Model\CartItem\CartItem;
use App\Identity\Domain\Model\UserId;
use App\Shared\Domain\Model\SKU;
use Symfony\Component\Routing\Attribute\Route;

class AddItemToCartHandler
{

    public function __construct(private CartRepository $repository)
    {
    }

    public function handle(AddItemToCartCommand $command) : void
    {
        $userId = UserId::create($command->getUserId());

        $cart = $this->repository->ofUserId($userId);

        if ($cart === null) {
            $cart = new Cart(
                $this->repository->nextIdentity(),
                UserId::create($userId),
                []
            );
        }

        $cart->addItem(
            new CartItem(
                SKU::create($command->getSku()),
                $command->getQuantity(),
            )
        );

        $this->repository->add($cart);
    }
}
