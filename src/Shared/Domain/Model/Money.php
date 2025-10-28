<?php

namespace App\Shared\Domain\Model;

class Money
{
    private int $amount;
    private Currency $currency;

    private function __construct(int $amount, Currency $currency)
    {
        $this->setAmount($amount);
        $this->currency = $currency;
    }

    private function setAmount(int $amount): void
    {
        if ($amount < 0) {
            throw new InvalidMoneyAmountException('Amount must be greater than 0');
        }
        $this->amount = $amount;
    }

    private function assertSameCurrency(Money $money): bool
    {
        return $this->currency->equalsTo($money->currency());
    }

    public static function create(int $amount, Currency $currenty): Money
    {
        return new Money($amount, $currenty);
    }

    public function add(Money $other): Money
    {
        $this->assertSameCurrency($other);

        return new Money($this->amount + $other->amount, $this->currency);
    }

    public function multiply(int $multiplier): Money
    {
        return new Money($this->amount * $multiplier, $this->currency);
    }

    public function equalsTo(Money $money): bool
    {
        return $this->amount === $money->amount
            && $this->currency->equalsTo($money->currency)
        ;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function formatted(): string
    {
        return number_format($this->amount / 100, 2, '.', '').' '.$this->currency->isoCode();
    }
}
