<?php

namespace App\Catalog\Infrastructure\Http\Controller\Category;

use App\Catalog\Application\Service\Category\CreateCategoryCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CreateCategoryController extends AbstractController
{

    public function __construct(
        private readonly CommandBus $commandBus,
    )
    {
    }

    #[Route('/categories', name: 'createCategory', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'])) {
            return $this->json([
                'success' => false,
                'message' => 'you must send a name to create a category'
            ], 400);
        }

        $this->commandBus->handle(new CreateCategoryCommand($data['name']));
        return $this->json(['success' => true], 201);
    }
}
