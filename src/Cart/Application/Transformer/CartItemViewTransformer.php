<?php

namespace App\Cart\Application\Transformer;

use App\Cart\Application\View\CartItemView;
use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\CartItem\CartItem;
use App\Catalog\Application\Service\Product\ViewProductsCommand;
use App\Catalog\Application\Service\Product\ViewProductsHandler;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;

class CartItemViewTransformer
{
    public function __construct(private ViewProductsHandler $viewProductsHandler)
    {
    }

    /**
     * @return CartItemView[]
     */
    public function assembleFrom(Cart $cart): array
    {
        $cartItems = $cart->items();

        if (empty($cartItems)) {
            return [];
        }

        $skus = array_map(
            fn (CartItem $item) => $item->sku()->value(),
            $cartItems
        );

        $productViews = $this->viewProductsHandler->handle(
            new ViewProductsCommand($skus)
        );

        $views = [];

        foreach ($cartItems as $cartItem) {
            $sku = $cartItem->sku()->value();
            $productView = $productViews[$sku] ?? null;

            if (null === $productView) {
                continue;
            }

            $unitPrice = Money::create(
                $productView->getPrice(),
                Currency::create($productView->getCurrency())
            );

            $lineTotal = $unitPrice->multiply($cartItem->quantity());

            $views[] = new CartItemView(
                $sku,
                $productView->getName(),
                $productView->getDescription(),
                $productView->getCategoryName(),
                $unitPrice,
                $cartItem->quantity(),
                $lineTotal
            );
        }

        return $views;
    }
}
