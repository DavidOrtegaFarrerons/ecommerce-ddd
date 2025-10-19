<?php

namespace App\Inventory\Application\Service;

use App\Inventory\Domain\Model\StockItem;
use App\Inventory\Domain\Model\StockItemAlreadyExistsException;
use App\Inventory\Domain\Model\StockItemRepository;
use App\Inventory\Domain\Model\StockQuantity;
use App\Shared\Domain\Model\SKU;

class CreateStockItemHandler
{
    public function __construct(private StockItemRepository $repository)
    {
    }

    public function handle(CreateStockItemCommand $command): void
    {
        $sku = SKU::create($command->getSku());
        $stockItem = $this->repository->ofSku($sku);
        if (null !== $stockItem) {
            throw new StockItemAlreadyExistsException("A StockItem with the sku {$sku->value()} already exists.");
        }

        $this->repository->add(
            new StockItem(
                $this->repository->nextIdentity(),
                $sku,
                StockQuantity::create(0)
            )
        );
    }
}
