<?php

namespace App\Shared\Infrastructure\Security;

use App\Identity\Domain\Model\User;
use App\Identity\Infrastructure\Persistence\Doctrine\UserMapper;
use Symfony\Bundle\SecurityBundle\Security;

class AuthenticatedUserProvider
{
    public function __construct(
        private Security $security,
        private UserMapper $userMapper,
    ) {
    }

    public function requireAuthenticatedUser(): User
    {
        $user = $this->security->getUser();

        if (null === $user) {
            throw new \RuntimeException('User not authenticated');
        }

        return $this->userMapper->toDomain($user);
    }
}
