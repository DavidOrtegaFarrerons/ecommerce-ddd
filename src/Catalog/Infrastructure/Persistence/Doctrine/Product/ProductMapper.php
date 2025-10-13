<?php

namespace App\Catalog\Infrastructure\Persistence\Doctrine\Product;

use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;
use Doctrine\ORM\EntityManagerInterface;

class ProductMapper
{
    public static function toRecord(Product $product) : ProductRecord
    {
        $r = new ProductRecord();
        $r->id = $product->id()->id();
        $r->sku = $product->sku()->value();
        $r->name = $product->name();
        $r->description = $product->description();
        $r->priceAmount = $product->price()->amount();
        $r->priceCurrency = $product->price()->currency();
        $r->categoryId = $product->categoryId()->id();
        $r->published = $product->published();

        return $r;
    }

    public static function toDomain(ProductRecord $productRecord): Product
    {
        return new Product(
            ProductId::create($productRecord->id),
            SKU::create($productRecord->sku),
            $productRecord->name,
            $productRecord->description,
            Money::create($productRecord->priceAmount, Currency::create($productRecord->priceCurrency)),
            CategoryId::create($productRecord->categoryId),
            $productRecord->published,
        );
    }
}
