<?php

namespace App\Inventory\Application\Service;

use App\Inventory\Application\Transformer\StockItemViewTransformer;
use App\Inventory\Application\View\StockItemView;
use App\Inventory\Domain\Model\StockItemNotFoundException;
use App\Inventory\Domain\Model\StockItemRepository;
use App\Shared\Domain\Model\SKU;

class GetStockItemHandler
{

    public function __construct(
        private readonly StockItemRepository $repository
    )
    {
    }

    public function handle(GetStockItemCommand $command): StockItemView
    {
        $sku = Sku::create($command->getSku());

        $stockItem = $this->repository->ofSku($sku);

        if ($stockItem === null) {
            throw new StockItemNotFoundException("No stock item was found with the sku: {$sku->value()}");
        }

        return StockItemViewTransformer::fromDomain($stockItem);
    }
}
