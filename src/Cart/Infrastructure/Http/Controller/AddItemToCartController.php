<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\AddItemToCartCommand;
use App\Identity\Infrastructure\Persistence\Doctrine\UserMapper;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AddItemToCartController extends AbstractController
{

    public function __construct(
        private readonly AuthenticatedUserProvider $authenticatedUserProvider,
        private readonly CommandBus $commandBus,
    )
    {
    }

    #[Route('/cart/items', name: 'cart_items', methods: ['POST'])]
    public function add(Request $request) : JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['sku'], $data['quantity'])) {
            return $this->json(
                [
                    'success' => false,
                    'message' => 'SKU and quantity are required fields'
                ]
            );
        }

        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();
        $this->commandBus->handle(new AddItemToCartCommand(
            $user->id()->id(),
            $data['sku'],
            $data['quantity']
        ));

        return $this->json(
            [
                'success' => true,
            ],
        );
    }
}
