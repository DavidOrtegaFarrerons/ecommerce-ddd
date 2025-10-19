<?php

namespace App\Inventory\Application\Listener;

use App\Catalog\Domain\Event\ProductCreated;
use App\Inventory\Application\Service\CreateStockItemCommand;
use League\Tactician\CommandBus;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class CreateStockItemWhenProductCreated
{

    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(ProductCreated $event): void
    {
        $this->commandBus->handle(
            new CreateStockItemCommand(
                $event->sku()
            )
        );
    }
}
