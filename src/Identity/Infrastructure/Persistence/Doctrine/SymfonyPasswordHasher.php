<?php

namespace App\Identity\Infrastructure\Persistence\Doctrine;

use App\Identity\Domain\Model\PasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class SymfonyPasswordHasher implements PasswordHasher
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function hash(string $plainPassword): string
    {
        return $this->hasher->hashPassword(
            new UserRecord(),
            $plainPassword
        );
    }
}
