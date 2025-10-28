<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Model\Cart\CartRepository;
use App\Identity\Domain\Model\UserId;
use App\Shared\Domain\Model\Address;

class SetShippingAddressHandler
{
    public function __construct(
        private CartFinder $cartFinder,
        private CartRepository $repository,
    ) {
    }

    public function handle(SetShippingAddressCommand $command): void
    {
        $userId = UserId::create($command->getUserId());
        $cart = $this->cartFinder->findOrFail($userId);

        $cart->changeShippingAddressTo(new Address(
            $command->getStreet(),
            $command->getCity(),
            $command->getPostalCode(),
            $command->getCountry()
        ));

        $this->repository->add($cart);
    }
}
