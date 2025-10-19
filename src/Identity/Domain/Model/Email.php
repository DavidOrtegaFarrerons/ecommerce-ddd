<?php

namespace App\Identity\Domain\Model;

use App\Identity\Domain\Model\Exception\InvalidEmailException;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = strtolower(trim($value));
        if (!$this->validate($normalizedValue)) {
            throw new InvalidEmailException($normalizedValue.' is not a valid email');
        }
        $this->value = $normalizedValue;
    }

    public function equals(Email $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function validate(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
