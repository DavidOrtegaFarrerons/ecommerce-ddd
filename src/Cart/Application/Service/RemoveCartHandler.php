<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\CartNotFoundException;
use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;

class RemoveCartHandler
{

    public function __construct(
        private CartFinder $cartFinder,
        private CartRepository $repository
    )
    {
    }

    public function handle(RemoveCartCommand $command)
    {
        $userId = UserId::create($command->getUserId());
        $cart = $this->cartFinder->findOrFail($userId);

        return $this->repository->remove($cart);
    }
}
