<?php

namespace App\Identity\Infrastructure\Persistence\Doctrine;

use App\Identity\Domain\Model\User;

class UserMapper
{
    public static function toRecord(User $user) : UserRecord
    {
        $r              = new UserRecord();
        $r->id          = $user->id();
        $r->email       = $user->email();
        $r->password    = $user->password();
        $r->firstName   = $user->firstName();
        $r->lastName    = $user->lastName();
        $r->roles       = $user->roles();

        return $r;
    }

    public static function toDomain(UserRecord $r) : User
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
