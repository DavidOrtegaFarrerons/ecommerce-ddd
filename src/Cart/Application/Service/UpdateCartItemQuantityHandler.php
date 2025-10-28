<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;
use App\Shared\Domain\Model\SKU;

class UpdateCartItemQuantityHandler
{
    public function __construct(
        private CartFinder $cartFinder,
        private CartRepository $cartRepository,
    ) {
    }

    public function handle(UpdateCartItemQuantityCommand $command)
    {
        $userId = UserId::create($command->getUserId());
        $cart = $this->cartFinder->findOrFail($userId);

        $cart->updateItemQuantity(SKU::create($command->getSKU()), $command->getQuantity());

        $this->cartRepository->add($cart);
    }
}
