<?php

namespace Src\RechargeDeposit\Exchange\Domain\ValueObjects;

class ExchangeId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('Invalid Exchange Id', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
