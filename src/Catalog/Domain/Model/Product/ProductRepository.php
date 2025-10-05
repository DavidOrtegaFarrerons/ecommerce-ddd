<?php

namespace App\Catalog\Domain\Model\Product;


interface ProductRepository
{
    public function nextIdentity() : ProductId;
    public function add(Product $product) : void;
    public function remove(Product $product) : void;
    public function ofId(ProductId $productId) : ?Product;
    public function ofName(string $name) : ?Product;
    public function ofSKU(string $sku) : ?Product;
}
