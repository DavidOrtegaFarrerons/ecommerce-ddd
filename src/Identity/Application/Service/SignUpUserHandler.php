<?php

namespace App\Identity\Application\Service;

use App\Identity\Domain\Model\Email;
use App\Identity\Domain\Model\PasswordHasher;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Model\UserRepository;

readonly class SignUpUserHandler
{

    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher
    )
    {
    }

    public function handle(SignUpUserCommand $command): void
    {
        $user = $this->userRepository->ofEmail(new Email($command->getEmail()));
        if ($user !== null) {
            throw new UserAlreadyExistsException();
        }

        $hashedPassword = $this->passwordHasher->hash($command->getPassword());

        $user = new User(
            $this->userRepository->nextIdentity(),
            new Email($command->getEmail()),
            $command->getFirstName(),
            $command->getLastName(),
            $hashedPassword
        );


        $this->userRepository->add($user);
    }
}
