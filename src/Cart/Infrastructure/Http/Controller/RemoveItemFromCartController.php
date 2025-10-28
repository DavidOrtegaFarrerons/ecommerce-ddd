<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\RemoveItemFromCartCommand;
use App\Shared\Domain\Model\SKU;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class RemoveItemFromCartController extends AbstractController
{
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private CommandBus $commandBus,
    ) {
    }

    #[Route('/cart/items/{sku}', name: 'cart_items_remove', methods: ['DELETE'])]
    public function removeItemFromCart(string $sku): JsonResponse
    {
        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();
        $sku = SKU::create($sku);
        $this->commandBus->handle(new RemoveItemFromCartCommand(
            $user->id()->id(),
            $sku->value()
        ));

        return $this->json([
            'success' => true,
        ]);
    }
}
