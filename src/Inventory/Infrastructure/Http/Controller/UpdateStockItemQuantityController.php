<?php

namespace App\Inventory\Infrastructure\Http\Controller;

use App\Inventory\Application\Service\UpdateStockItemQuantityCommand;
use App\Inventory\Domain\Model\StockItemNotFoundException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UpdateStockItemQuantityController extends AbstractController
{

    public function __construct(private CommandBus $commandBus)
    {
    }

    #[Route('inventory/{sku}', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(string $sku, Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);



        if (!isset($data['quantity'])) {
            return $this->json([
                'success' => false,
                'message' => 'A quantity is needed to update the StockItem'
            ]);
        }

        try {
            $this->commandBus->handle(
                new UpdateStockItemQuantityCommand($sku, $data['quantity'])
            );
        } catch (StockItemNotFoundException $exception) {
            return $this->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }


        return $this->json([], 204);
    }
}
