<?php

namespace App\Catalog\Domain\Model\Product;

use App\Catalog\Domain\Model\Category\CategoryId;
use App\Shared\Domain\Currency;
use App\Shared\Domain\Money;

class ProductFactory
{
    public function create(
        ProductId $id,
        string $sku,
        string $name,
        string $description,
        int $priceAmount,
        string $priceCurrency,
        string $categoryId
    ) : Product
    {
        return new Product(
            $id,
            SKU::create($sku),
            $name,
            $description,
            Money::create(
                $priceAmount,
                Currency::create($priceCurrency)
            ),
            CategoryId::create($categoryId)
        );
    }
}
