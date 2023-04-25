<?php

namespace Src\RechargeDeposit\Currency\Domain\ValueObjects;

class CurrencyId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function validate(): void
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('invalid currency id', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }


}
