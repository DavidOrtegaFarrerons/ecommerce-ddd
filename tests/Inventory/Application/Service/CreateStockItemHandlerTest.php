<?php

namespace App\Tests\Inventory\Application\Service;

use App\Inventory\Application\Service\CreateStockItemCommand;
use App\Inventory\Application\Service\CreateStockItemHandler;
use App\Inventory\Domain\Model\StockItemAlreadyExistsException;
use App\Inventory\Infrastructure\Persistence\InMemory\InMemoryStockItemRepository;
use App\Shared\Domain\Model\SKU;
use PHPUnit\Framework\TestCase;

class CreateStockItemHandlerTest extends TestCase
{
    private InMemoryStockItemRepository $repository;
    private CreateStockItemHandler $handler;

    protected function setUp(): void
    {
        $this->repository = new InMemoryStockItemRepository();
        $this->handler = new CreateStockItemHandler($this->repository);
    }

    public function testStockItemCanBeCreated(): void
    {
        $command = new CreateStockItemCommand('ABC-123');

        $this->handler->handle($command);

        $stockItem = $this->repository->ofSku(SKU::create('ABC-123'));
        self::assertNotNull($stockItem);
        self::assertSame('ABC-123', $stockItem->sku()->value());
        self::assertSame(0, $stockItem->quantity()->value());
    }

    public function testCannotCreateStockItemWithExistingSku(): void
    {
        $command = new CreateStockItemCommand('ABC-123');

        $this->handler->handle($command);

        $this->expectException(StockItemAlreadyExistsException::class);
        $this->expectExceptionMessage("A StockItem with the sku ABC-123 already exists.");

        $this->handler->handle($command);
    }
}
