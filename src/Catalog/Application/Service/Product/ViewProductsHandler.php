<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Application\Transformer\Product\ProductViewTransformer;
use App\Catalog\Application\View\ProductView;
use App\Catalog\Domain\Model\Category\CategoryRepository;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;

class ViewProductsHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
        private ProductViewTransformer $assembler,
    ) {
    }

    /**
     * @return ProductView[]
     */
    public function handle(ViewProductsCommand $command): array
    {
        $skus = array_map(function (string $sku) {
            return SKU::create($sku);
        }, $command->getSkus());

        $products = $this->productRepository->ofSkus($skus);

        $categoryNames = [];
        foreach ($products as $product) {
            $categoryId = $product->categoryId()->id();
            if (!isset($categoryNames[$categoryId])) {
                $category = $this->categoryRepository->ofId($product->categoryId());
                if (null === $category || '' === $category->name()) {
                    continue;
                }

                $categoryNames[$categoryId] = $category->name();
            }
        }

        $views = [];
        foreach ($products as $product) {
            $views[$product->sku()->value()] = $this->assembler->assembleFrom(
                $product,
                $categoryNames[$product->categoryId()->id()],
            );
        }

        return $views;
    }
}
