<?php

namespace App\Catalog\Domain\Model\Product;


use App\Shared\Domain\Model\SKU;

interface ProductRepository
{
    public function nextIdentity() : ProductId;
    public function add(Product $product) : void;
    public function remove(Product $product) : void;
    public function ofId(ProductId $productId) : ?Product;
    public function ofName(string $name) : ?Product;
    public function ofSku(SKU $sku) : ?Product;
    public function findByFilters(SKU $sku, string $name, int $price, string $categoryName) : array;
}
