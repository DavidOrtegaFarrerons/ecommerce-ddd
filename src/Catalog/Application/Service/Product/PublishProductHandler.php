<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;

class PublishProductHandler
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function handle(PublishProductCommand $command): void
    {
        $product = $this->productRepository->ofSku(SKU::create($command->getSku()));

        if (null === $product) {
            throw new ProductDoesNotExistException("The product with sku {$command->getSku()} doesn't exist");
        }

        $product->publish();

        $this->productRepository->add($product);
    }
}
