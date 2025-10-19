<?php

namespace App\Catalog\Application\Service\Product;

use App\Catalog\Domain\Model\Product\ProductAlreadyExistsException;
use App\Catalog\Domain\Model\Product\ProductFactory;
use App\Catalog\Domain\Model\Product\ProductRepository;
use App\Shared\Domain\Model\SKU;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

readonly class CreateProductHandler
{
    public function __construct(
        private ProductRepository $repository,
        private ProductFactory $factory,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function handle(CreateProductCommand $command): void
    {
        $product = $this->repository->ofName($command->getName());

        if (null !== $product) {
            throw new ProductAlreadyExistsException("A product with the name '{$command->getName()}' already exists.");
        }

        $product = $this->repository->ofSku(SKU::create($command->getSKU()));

        if (null !== $product) {
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

        foreach ($product->pullDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
