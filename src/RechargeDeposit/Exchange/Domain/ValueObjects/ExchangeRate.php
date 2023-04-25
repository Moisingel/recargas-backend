<?php

namespace Src\RechargeDeposit\Exchange\Domain\ValueObjects;

class ExchangeRate
{
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('Invalid Exchange Rate', 400);
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}
