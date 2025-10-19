<?php

namespace App\Identity\Domain\Model;

interface UserRepository
{
    public function nextIdentity(): UserId;

    public function add(User $user): void;

    public function remove(User $user): void;

    public function ofId(UserId $userId): ?User;

    public function ofEmail(Email $email): ?User;
}
