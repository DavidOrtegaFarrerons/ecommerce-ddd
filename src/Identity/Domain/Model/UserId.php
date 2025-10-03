<?php

namespace App\Identity\Domain\Model;

use App\Shared\Domain\UuidId;

class UserId extends UuidId {
    public function equalsTo(UserId $userId): bool
    {
        return $this->id() === $userId->id();
    }
}
