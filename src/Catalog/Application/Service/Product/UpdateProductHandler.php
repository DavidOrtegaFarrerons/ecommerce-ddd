<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Category\CategoryDoesNotExistException;
use App\Catalog\Domain\Model\Category\CategoryId;
use App\Catalog\Domain\Model\Category\CategoryRepository;
use App\Catalog\Domain\Model\Product\ProductDoesNotExistException;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\Currency;
use App\Shared\Domain\Model\Money;
use App\Shared\Domain\Model\SKU;

readonly class UpdateProductHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function handle(UpdateProductCommand $command): void
    {
        $product = $this->productRepository->ofSku(SKU::create($command->getSku()));

        if (null === $product) {
            throw new ProductDoesNotExistException("The product with sku {$command->getSku()} doesn't exist");
        }

        if (null !== $command->getName()) {
            $product->renameTo($command->getName());
        }

        if (null !== $command->getDescription()) {
            $product->changeDescriptionTo($command->getDescription());
        }

        $priceAmount = null !== $command->getPriceAmount() ? $command->getPriceAmount() : $product->price()->amount();
        $priceCurrency = null !== $command->getPriceCurrency() ? $command->getPriceCurrency() : $product->price()->currency()->isoCode();

        $product->repriceTo(
            Money::create(
                $priceAmount,
                Currency::create($priceCurrency)
            )
        );

        if (null !== $command->getCategoryId()) {
            $category = $this->categoryRepository->ofId(CategoryId::create($command->getCategoryId()));

            if (null === $category) {
                throw new CategoryDoesNotExistException("The category with id {$command->getCategoryId()} doesn't exist");
            }

            $product->changeCategoryTo(CategoryId::create($command->getCategoryId()));
        }

        $this->productRepository->add($product);
    }
}
