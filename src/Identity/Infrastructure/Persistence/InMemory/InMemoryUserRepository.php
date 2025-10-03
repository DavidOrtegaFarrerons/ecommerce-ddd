<?php

namespace App\Identity\Infrastructure\Persistence\InMemory;

use App\Identity\Domain\Model\Email;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Model\UserId;
use App\Identity\Domain\Model\UserRepository;
use Symfony\Component\Uid\Uuid;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var array<string, User>
     */
    private array $users = [];

    public function nextIdentity(): UserId
    {
        return new UserId();
    }

    public function add(User $user) : void
    {
        $this->users[$user->id()->id()] = $user;
    }

    public function remove(User $user) : void
    {
        unset($this->users[$user->id()->id()]);
    }

    public function ofId(UserId $userId) : ?User
    {
        if (isset($this->users[$userId->id()])) {
            return $this->users[$userId->id()];
        }

        return null;
    }

    public function ofEmail(Email $email) : ?User
    {
        foreach ($this->users as $user) {
            if ($user->email()->equals($email)) {
                return $user;
            }
        }

        return null;
    }
}
