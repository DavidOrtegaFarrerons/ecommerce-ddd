<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Domain\Model\Product\SKU;

class UnpublishProductHandler
{

    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    public function handle(PublishProductCommand $command) : void
    {
        $product = $this->productRepository->ofSKU(SKU::create($command->getSku()));

        if ($product === null) {
            throw new ProductDoesNotExistException("The product with sku {$command->getSku()} doesn't exist");
        }

        $product->unpublish();

        $this->productRepository->add($product);
    }
}
