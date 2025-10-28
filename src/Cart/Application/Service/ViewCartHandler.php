<?php

namespace App\Cart\Application\Service;

use App\Cart\Application\Transformer\CartItemViewTransformer;
use App\Identity\Domain\Model\UserId;

class ViewCartHandler
{

    public function __construct(
        private CartFinder $cartFinder,
        private CartItemViewTransformer $transformer,
    )
    {
    }

    public function handle(ViewCartCommand $command)
    {
        $userId = UserId::create($command->getUserId());
        $cart = $this->cartFinder->findOrFail($userId);

        return  $this->transformer->assembleFrom($cart);
    }
}
