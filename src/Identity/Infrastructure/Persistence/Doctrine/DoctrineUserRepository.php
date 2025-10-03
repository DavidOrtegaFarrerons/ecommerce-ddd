<?php

namespace App\Identity\Infrastructure\Persistence\Doctrine;

use App\Identity\Domain\Model\Email;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Model\UserId;
use App\Identity\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineUserRepository implements UserRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function nextIdentity(): UserId
    {
        return UserId::create();
    }

    public function add(User $user): void
    {
        $record = UserMapper::toRecord($user);
        $this->em->persist($record);
        $this->em->flush();
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
    }

    public function ofId(UserId $userId) : ?User
    {
        $record = $this->em->find(UserRecord::class, $userId);
        return $record ? UserMapper::toDomain($record) : null;
    }

    public function ofEmail(Email $email) : ?User
    {
        $record = $this->em
            ->getRepository(UserRecord::class)
            ->findOneBy(['email' => $email])
        ;

        return $record ? UserMapper::toDomain($record) : null;
    }
}
