<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\UpdateCartItemQuantityCommand;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UpdateCartItemController extends AbstractController
{
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private CommandBus $commandBus,
    ) {
    }

    #[Route('/cart/items', name: 'cart_items_update', methods: ['PATCH'])]
    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['sku'], $data['quantity'])) {
            return $this->json(
                [
                    'success' => false,
                    'message' => 'SKU and quantity are needed to update the item in the cart',
                ]
            );
        }

        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();
        $this->commandBus->handle(new UpdateCartItemQuantityCommand(
            $user->id()->id(),
            $data['sku'],
            $data['quantity']
        ));

        return $this->json([
            'success' => true,
        ]);
    }
}
