<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Category\CategoryDoesNotExistException;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Category\CategoryRepository;
use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Catalog\Domain\Model\Product\SKU;
use App\Shared\Domain\Currency;
use App\Shared\Domain\Money;

readonly class UpdateProductHandler
{

    public function __construct(
        private ProductRepository  $productRepository,
        private CategoryRepository $categoryRepository,
    )
    {
    }

    public function handle(UpdateProductCommand $command) : void
    {
        $product = $this->productRepository->ofSKU(SKU::create($command->getSku()));

        if ($product === null) {
            throw new ProductDoesNotExistException("The product with sku {$command->getSku()} doesn't exist");
        }

        if ($command->getName() !== null) {
            $product->renameTo($command->getName());
        }

        if ($command->getDescription() !== null) {
            $product->changeDescriptionTo($command->getDescription());
        }

        $priceAmount = $command->getPriceAmount() !== null ? $command->getPriceAmount() : $product->price()->amount();
        $priceCurrency = $command->getPriceCurrency() !== null ? $command->getPriceCurrency() : $product->price()->currency()->isoCode();

        $product->repriceTo(
            Money::create(
                $priceAmount,
                Currency::create($priceCurrency)
            )
        );

        if ($command->getCategoryId() !== null) {
            $category = $this->categoryRepository->ofId(CategoryId::create($command->getCategoryId()));

            if ($category === null) {
                throw new CategoryDoesNotExistException("The category with id {$command->getCategoryId()} doesn't exist");
            }

            $product->changeCategoryTo(CategoryId::create($command->getCategoryId()));
        }

        $this->productRepository->add($product);
    }
}
