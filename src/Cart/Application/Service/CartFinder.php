<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\Cart\CartNotFoundException;
use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;

class CartFinder
{

    public function __construct(private CartRepository $repository)
    {
    }

    public function findOrFail(UserId $userId): Cart
    {
        $cart = $this->repository->ofUserId($userId);
        if ($cart === null) {
            throw new CartNotFoundException("No cart was found for userId: {$userId->id()}");
        }

        return $cart;
    }
}
