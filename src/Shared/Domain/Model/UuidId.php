<?php

namespace App\Shared\Domain\Model;

use Symfony\Component\Uid\Uuid;

abstract class UuidId
{
    private string $id;

    /**
     * @param string|null $id
     */
    private function __construct(?string $id = null)
    {
        if ($id === null || !Uuid::isValid($id)) {
            $this->id = Uuid::v4()->toString();
            return;
        }

        $this->id = $id;
    }

    public function id() : string
    {
        return $this->id;
    }

    public static function create(?string $id = null) : static
    {
        return new static($id);
    }

    public function __toString() : string
    {
        return $this->id;
    }
}
