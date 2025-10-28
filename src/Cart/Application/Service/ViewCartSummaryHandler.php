<?php

namespace App\Cart\Application\Service;

use App\Cart\Application\Transformer\CartItemViewTransformer;
use App\Cart\Application\View\CartSummaryView;
use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;

class ViewCartSummaryHandler
{

    public function __construct
    (
        private CartFinder $cartFinder,
         private CartRepository $repository,
         private CartItemViewTransformer $transformer,
        private CartTotalCalculator $calculator,
    )
    {
    }

    public function handle(ViewCartSummaryCommand $command) : CartSummaryView
    {
        $userId = UserId::create($command->getUserId());
        $cart = $this->cartFinder->findOrFail($userId);

        $cartItemViews = $this->transformer->assembleFrom($cart);

        return new CartSummaryView(
            $cart->shippingAddress(),
            $cartItemViews,
            $this->calculator->calculate($cart)
        );
    }
}
