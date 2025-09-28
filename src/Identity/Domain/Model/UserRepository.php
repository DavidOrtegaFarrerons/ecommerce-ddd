<?php

namespace App\Identity\Domain\Model;

interface UserRepository
{
    public function nextIdentity() : UserId;
    public function add(User $user);
    public function remove(User $user);
    public function ofId(UserId $userId);
    public function ofEmail(Email $email);
}
