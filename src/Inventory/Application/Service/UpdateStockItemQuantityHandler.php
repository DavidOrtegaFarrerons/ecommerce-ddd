<?php

namespace App\Inventory\Application\Service;

use App\Inventory\Domain\Model\StockItemNotFoundException;
use App\Inventory\Domain\Model\StockItemRepository;
use App\Shared\Domain\Model\SKU;

class UpdateStockItemHandler
{

    public function __construct(
        private StockItemRepository $repository,
    )
    {
    }

    public function handle(UpdateStockItemCommand $command) : void
    {
        $sku = SKU::create($command->getSku());
        $stockItem = $this->repository->ofSku($sku);

        if ($stockItem === null) {
            throw new StockItemNotFoundException("No stockItem found with sku {$sku->value()}");
        }

        $stockItem->adjustStockBy($command->getQuantity());

        $this->repository->add($stockItem);
    }
}
