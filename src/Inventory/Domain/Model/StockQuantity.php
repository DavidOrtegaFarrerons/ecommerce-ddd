<?php

namespace App\Inventory\Domain\Model;

class StockQuantity
{
    private int $value;

    /**
     * @param int $value
     */
    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidQuantityException("Quantity must be a positive number");
        }

        $this->value = $value;
    }

    public static function create(int $value): self {
        return new StockQuantity($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(StockQuantity $quantity): bool
    {
        return $this->value === $quantity->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
