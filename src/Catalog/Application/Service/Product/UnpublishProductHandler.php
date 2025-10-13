<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;

class UnpublishProductHandler
{

    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    public function handle(UnpublishProductCommand $command) : void
    {
        $product = $this->productRepository->ofSku(SKU::create($command->getSku()));

        if ($product === null) {
            throw new ProductDoesNotExistException("The product with sku {$command->getSku()} doesn't exist");
        }

        $product->unpublish();

        $this->productRepository->add($product);
    }
}
