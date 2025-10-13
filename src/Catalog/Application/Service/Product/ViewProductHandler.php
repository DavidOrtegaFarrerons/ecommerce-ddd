<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Application\Transformer\Product\ProductViewAssembler;
use App\Catalog\Application\View\ProductView;
use App\Catalog\Domain\Model\Category\CategoryDoesNotExistException;
use App\Catalog\Domain\Model\Category\CategoryRepository;
use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;

class ViewProductHandler
{

    public function __construct(
        private ProductRepository  $productRepository,
        private CategoryRepository $categoryRepository,
        private ProductViewAssembler $assembler,
    )
    {
    }

    public function handle(ViewProductCommand $command) : ProductView
    {
        $product = $this->productRepository->ofSku(SKU::create($command->getSku()));

        if ($product === null) {
            throw new ProductDoesNotExistException("The product with sku {$command->getSku()} does not exist");
        }

        $category = $this->categoryRepository->ofId($product->categoryId());

        if ($category === null) {
            throw new CategoryDoesNotExistException("The category from the product with sku {$command->getSku()} does not exist");
        }

        return $this->assembler->assembleFrom($product, $category->name());
    }
}
