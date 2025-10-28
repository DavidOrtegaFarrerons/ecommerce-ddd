<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\ViewCartSummaryCommand;
use App\Cart\Application\View\CartItemView;
use App\Cart\Application\View\CartSummaryView;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ViewCartSummaryController extends AbstractController
{
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private CommandBus $commandBus,
    ) {
    }

    #[Route('/checkout/review', name: 'cart_review', methods: ['GET'])]
    public function summary()
    {
        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();
        /** @var CartSummaryView $view */
        $view = $this->commandBus->handle(new ViewCartSummaryCommand(
            $user->id()->id()
        ));

        return $this->json([
            'shippingAddress' => [
                'street' => $view->getShippingAddress()->street(),
                'city' => $view->getShippingAddress()->city(),
                'postalCode' => $view->getShippingAddress()->postalCode(),
                'country' => $view->getShippingAddress()->country(),
            ],
            'items' => array_map(fn (CartItemView $item) => [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'categoryName' => $item->getCategoryName(),
                'price' => [
                    'amount' => $item->getUnitPrice()->amount(),
                    'currency' => $item->getUnitPrice()->currency()->isoCode(),
                    'formatted' => $item->getUnitPrice()->formatted(),
                ],
                'quantity' => $item->getQuantity(),
            ], $view->getCartItemsViews()),
            'total' => [
                'amount' => $view->getTotal()->amount(),
                'currency' => $view->getTotal()->currency()->isoCode(),
                'formatted' => $view->getTotal()->formatted(),
            ],
        ]);
    }
}
