<?php

namespace App\Catalog\Infrastructure\Http\Controller\Product;

use App\Catalog\Application\Service\Product\ListProductsCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ListProductsController extends AbstractController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    #[Route('/products', name: 'list_products', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->commandBus->handle(new ListProductsCommand(
            $request->get('sku'),
            $request->get('name'),
            $request->get('price'),
            $request->get('categoryName')
        ));
    }
}
