<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\Cart;
use App\Cart\Domain\Model\CartItem\CartItem;
use App\Catalog\Application\Service\Product\ViewProductsCommand;
use App\Catalog\Application\Service\Product\ViewProductsHandler;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;

class CartTotalCalculator
{
    public function __construct(
        private ViewProductsHandler $viewProductsHandler,
    ) {
    }

    public function calculate(Cart $cart): Money
    {
        $skus = array_map(
            fn (CartItem $item) => $item->sku()->value(),
            $cart->items()
        );

        $productViews = $this->viewProductsHandler->handle(new ViewProductsCommand($skus));

        $total = Money::create(0, Currency::create('EUR'));

        foreach ($cart->items() as $item) {
            $sku = $item->sku()->value();
            $product = $productViews[$sku] ?? null;
            if (!$product) {
                continue;
            }

            $price = Money::create($product->getPrice(), Currency::create($product->getCurrency()));
            $total = $total->add($price->multiply($item->quantity()));
        }

        return $total;
    }
}
