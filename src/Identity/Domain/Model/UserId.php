<?php

namespace App\Identity\Domain\Model;

use Symfony\Component\Uid\Uuid;

class UserId
{
    private string $id;

    /**
     * @param string|null $id
     */
    public function __construct(string $id = null)
    {
        if ($id === null || !Uuid::isValid($id)) {
            $this->id = Uuid::v4()->toString();
            return;
        }

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function create(string $id = null): static
    {
        return new static($id);
    }

    public function equalsTo(UserId $userId): bool
    {
        return $userId->id() === $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
