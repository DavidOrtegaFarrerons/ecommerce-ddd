<?php

namespace App\Catalog\Infrastructure\Http\Controller\Product;

use App\Catalog\Application\Service\Product\PublishProductCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PublishProductController extends AbstractController
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/products/{sku}/publish', name: 'publish_product', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function publish(string $sku) : JsonResponse
    {
        if ($sku === null) {
            return $this->json(
                [
                    'success' => false,
                    'message' => 'no SKU has been given'
                ]
            );
        }
        $this->commandBus->handle(new PublishProductCommand($sku));

        return $this->json(
            [
                'success' => true,
                'published' => true
            ]
        );
    }
}
