<?php

namespace App\Catalog\Infrastructure\Persistence\InMemory\Product;

use App\Catalog\Domain\Model\Product\Product;
use App\Catalog\Domain\Model\Product\ProductId;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;

class InMemoryProductRepository implements ProductRepository
{
    /**
     * @var array<string, Product>
     */
    private array $products = [];

    public function nextIdentity(): ProductId
    {
        return ProductId::create();
    }

    public function add(Product $product): void
    {
        $this->products[$product->id()->id()] = $product;
    }

    public function remove(Product $product): void
    {
        unset($this->products[$product->id()->id()]);
    }

    public function ofId(ProductId $productId): ?Product
    {
        if (isset($this->products[$productId->id()])) {
            return $this->products[$productId->id()];
        }

        return null;
    }

    public function ofName(string $name): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->name() === $name) {
                return $product;
            }
        }

        return null;
    }

    public function ofSku(SKU $sku): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->sku()->equalsTo($sku)) {
                return $product;
            }
        }

        return null;
    }

    public function findByFilters(SKU $sku, string $name, int $price, string $categoryName): array
    {
        return [];
    }

    public function ofSkus(array $skus): ?array
    {
        $products = [];
        foreach ($this->products as $product) {
            if (in_array($product->sku()->value(), $skus)) {
                $products[] = $product;
            }
        }

        return $products;
    }
}
