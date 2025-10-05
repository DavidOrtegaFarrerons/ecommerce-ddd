<?php

namespace App\Catalog\Infrastructure\Http\Controller\Product;

use App\Catalog\Application\Service\Product\CreateProductCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CreateProductController extends AbstractController
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/products', name: 'create_product', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset(
                $data['sku'],
                $data['name'],
                $data['description'],
                $data['priceAmount'],
                $data['priceCurrency'],
                $data['categoryId'],
            )
        ){
           return $this->json(
               [
                   'success' => false,
                   'message' => 'Data is missing or invalid'
               ],
               400
           );
        }

        $this->commandBus->handle(
            new CreateProductCommand(
                $data['sku'],
                $data['name'],
                $data['description'],
                $data['priceAmount'],
                $data['priceCurrency'],
                $data['categoryId']
            )
        );

        return $this->json(['success' => true], 201);
    }
}
