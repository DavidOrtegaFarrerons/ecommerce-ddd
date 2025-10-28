<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\RemoveCartCommand;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class RemoveCartController extends AbstractController
{
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private CommandBus $commandBus,
    ) {
    }

    #[Route('/cart', name: 'remove_cart', methods: ['DELETE'])]
    public function remove()
    {
        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();
        $this->commandBus->handle(new RemoveCartCommand(
            $user->id()->id()
        ));

        return $this->json([
            'success' => true,
        ]);
    }
}
