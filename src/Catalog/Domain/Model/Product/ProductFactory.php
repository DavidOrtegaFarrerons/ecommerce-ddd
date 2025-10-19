<?php

namespace App\Catalog\Domain\Model\Product;

use App\Catalog\Domain\Model\Category\CategoryId;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;

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
        return Product::create(
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
