<?php

namespace App\Inventory\Application\Service;

use App\Inventory\Domain\Model\StockItemNotFoundException;
use App\Inventory\Domain\Model\StockItemRepository;
use App\Inventory\Domain\Model\StockQuantity;
use App\Shared\Domain\Model\SKU;

class UpdateStockItemQuantityHandler
{
    public function __construct(
        private StockItemRepository $repository,
    ) {
    }

    public function handle(UpdateStockItemQuantityCommand $command): void
    {
        $sku = SKU::create($command->getSku());
        $stockItem = $this->repository->ofSku($sku);

        if (null === $stockItem) {
            throw new StockItemNotFoundException("No stockItem found with sku {$sku->value()}");
        }

        $stockItem->setStockTo(StockQuantity::create($command->getQuantity()));

        $this->repository->add($stockItem);
    }
}
