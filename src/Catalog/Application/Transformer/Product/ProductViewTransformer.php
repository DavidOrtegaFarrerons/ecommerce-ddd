<?php

namespace App\Catalog\Application\Transformer\Product;

use App\Catalog\Application\View\ProductView;
use App\Catalog\Domain\Model\Product\Product;

class ProductViewTransformer
{
    public function assembleFrom(Product $product, string $categoryName) : ProductView
    {
        return new ProductView(
            $product->sku()->value(),
            $product->name(),
            $product->description(),
            $categoryName,
            $product->price()->amount(),
            $product->price()->currency(),
        );
    }
}
