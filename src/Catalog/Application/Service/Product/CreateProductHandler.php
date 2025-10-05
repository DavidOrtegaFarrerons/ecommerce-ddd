<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Product\ProductFactory;
use App\Catalog\Domain\Model\Product\ProductRepository;

readonly class CreateProductHandler
{

    public function __construct(
        private ProductRepository $repository,
        private ProductFactory    $factory
    )
    {
    }

    public function handle(CreateProductCommand $command) : void
    {
        $product = $this->repository->ofName($command->getName());

        if ($product !== null) {
            throw new ProductAlreadyExistsException("A product with the name '{$command->getName()}' already exists.");
        }

        $product = $this->repository->ofSKU($command->getSKU());

        if ($product !== null) {
            throw new ProductAlreadyExistsException("A product with the SKU '{$command->getSKU()}' already exists.");
        }

        $product = $this->factory->create(
            $this->repository->nextIdentity(),
            $command->getSKU(),
            $command->getName(),
            $command->getDescription(),
            $command->getPriceAmount(),
            $command->getPriceCurrency(),
            $command->getCategoryId()
        );

        $this->repository->add($product);
    }
}
