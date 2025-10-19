<?php

namespace App\Inventory\Infrastructure\Http\Controller;

use App\Inventory\Application\Service\GetStockItemCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GetStockItemController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    #[Route('/inventory/{sku}', name: 'get_stockItem', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function get(string $sku)
    {
        return $this->json(
            $this->commandBus->handle(
                new GetStockItemCommand($sku)
            )
        );
    }
}
