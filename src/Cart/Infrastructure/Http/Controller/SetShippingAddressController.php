<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\SetShippingAddressCommand;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SetShippingAddressController extends AbstractController
{
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private CommandBus $commandBus
    )
    {
    }

    #[Route('/checkout/shipping-address', name: 'cart_checkout_shipping-address', methods: ['PATCH'])]
    public function setShippingAddres(Request $request) : JsonResponse
    {
        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();

        $data = json_decode($request->getContent(), true);

        if (!isset(
            $data['street'],
            $data['city'],
            $data['zip'],
            $data['country']
        )) {
            return $this->json([
                'success' => false,
                'message' => 'Street, city, zip and country are required fields'
            ]);
        }

        $this->commandBus->handle(
            new SetShippingAddressCommand(
                $user->id()->id(),
                $data['street'],
                $data['city'],
                $data['zip'],
                $data['country']
            )
        );

        return $this->json([
            'success' => true,
        ]);
    }
}
