<?php

namespace App\Catalog\Infrastructure\Http\Controller\Product;

use App\Catalog\Application\Service\Product\ViewProductCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ViewProductController extends AbstractController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    #[Route('/products/{sku}', name: 'get_product', methods: ['GET'])]
    public function get(string $sku): JsonResponse
    {
        $sku = trim($sku);

        if ('' === $sku) {
            return $this->json([
                'success' => false,
                'message' => 'SKU can not be empty.',
            ], 400);
        }

        $data = $this->commandBus->handle(new ViewProductCommand($sku));

        return $this->json($data);
    }
}
