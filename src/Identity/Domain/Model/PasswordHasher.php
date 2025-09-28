<?php

namespace App\Identity\Domain\Model;

interface PasswordHasher
{
    public function hash(string $plainPassword): string;
}
