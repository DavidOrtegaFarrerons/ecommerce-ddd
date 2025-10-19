<?php

namespace App\Identity\Infrastructure\Persistence\Doctrine;

use App\Identity\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;

class UserMapper
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function toRecord(User $user): UserRecord
    {
        $r = $this->em->find(UserRecord::class, $user->id()->id());
        if (null === $r) {
            $r = new UserRecord();
            $r->id = $user->id();
        }

        $r->email = $user->email();
        $r->password = $user->password();
        $r->firstName = $user->firstName();
        $r->lastName = $user->lastName();
        $r->roles = $user->roles();

        return $r;
    }

    public function toDomain(UserRecord $r): User
    {
        return new User(
            $r->id,
            $r->email,
            $r->firstName,
            $r->lastName,
            $r->password,
            $r->roles
        );
    }
}
