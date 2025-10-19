<?php

namespace App\Shared\Domain\Model;

class SKU
{
    private string $value;

    private function __construct(?string $value = null)
    {
        $normalized = strtoupper(trim($value));

        if (!preg_match('/^[A-Z0-9\-]+$/', $normalized)) {
            throw new InvalidSKUException("Invalid SKU: $value");
        }

        $this->value = $normalized;
    }

    private static function fake(): SKU
    {
        return new SKU('SKU-'.bin2hex(random_bytes(8)));
    }

    public static function create(?string $value = null): SKU
    {
        if (null === $value || '' === $value) {
            return self::fake();
        }

        return new self($value);
    }

    public function equalsTo(SKU $sku): bool
    {
        return $this->value === $sku->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
