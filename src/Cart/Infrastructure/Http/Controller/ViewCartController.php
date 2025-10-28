<?php

namespace App\Cart\Infrastructure\Http\Controller;

use App\Cart\Application\Service\ViewCartCommand;
use App\Shared\Infrastructure\Security\AuthenticatedUserProvider;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ViewCartController extends AbstractController
{

    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private CommandBus $commandBus,
        private SerializerInterface $serializer
    )
    {
    }

    #[Route('/cart', name: 'view_cart', methods: ['GET'])]
    public function view()
    {
        $user = $this->authenticatedUserProvider->requireAuthenticatedUser();

        $view = $this->commandBus->handle(new ViewCartCommand(
            $user->id()->id()
        ));

        //TODO Money into MoneyView so that the view can be directly json encoded
        $data = array_map(static function ($item) {
            return [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'categoryName' => $item->getCategoryName(),
                'unitPrice' => [
                    'amount' => $item->getUnitPrice()->amount(),
                    'currency' => $item->getUnitPrice()->currency()->isoCode(),
                    'formatted' => $item->getUnitPrice()->formatted(),
                ],
                'quantity' => $item->getQuantity(),
                'lineTotal' => [
                    'amount' => $item->getLineTotal()->amount(),
                    'currency' => $item->getLineTotal()->currency()->isoCode(),
                    'formatted' => $item->getLineTotal()->formatted(),
                ],
            ];
        }, $view);

        return $this->json($data);
    }
}
