<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;
use App\Shared\Domain\Model\SKU;

class RemoveItemFromCartHandler
{
    public function __construct(
        private CartFinder $cartFinder,
        private CartRepository $repository,
    ) {
    }

    public function handle(RemoveItemFromCartCommand $command)
    {
        $userId = UserId::create($command->getUserId());
        $cart = $this->cartFinder->findOrFail($userId);
        $cart->removeItem(SKU::create($command->getSku()));

        $this->repository->add($cart);
    }
}
