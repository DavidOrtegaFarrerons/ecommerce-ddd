<?php

namespace App\Shared\Domain\Model;

class Currency
{
    private string $isoCode;

    private function __construct(string $isoCode)
    {
        $this->isoCode = $isoCode;
    }

    public static function create(string $isoCode): Currency
    {
        return new self($isoCode);
    }

    public function equalsTo(Currency $currency): bool
    {
        return $this->isoCode === $currency->isoCode;
    }

    public function isoCode(): string
    {
        return $this->isoCode;
    }

    public function __toString(): string
    {
        return $this->isoCode;
    }
}
