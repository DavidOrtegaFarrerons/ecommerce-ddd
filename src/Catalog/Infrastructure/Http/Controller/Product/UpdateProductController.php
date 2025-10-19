<?php

namespace App\Catalog\Infrastructure\Http\Controller\Product;

use App\Catalog\Application\Service\Product\UpdateProductCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UpdateProductController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    #[Route('/products/{sku}', name: 'update_product', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Request $request, string $sku): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'No fields sent for update',
                ],
                400
            );
        }

        $this->commandBus->handle(
            new UpdateProductCommand(
                $sku,
                $data['name'],
                $data['description'],
                $data['priceAmount'],
                $data['priceCurrency'],
                $data['categoryId']
            )
        );

        return $this->json(
            [
                'success' => true,
            ]
        );
    }
}
