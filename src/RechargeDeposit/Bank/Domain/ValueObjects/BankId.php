<?php

namespace Src\RechargeDeposit\Bank\Domain\ValueObjects;

class BankId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if ($this->value < 1) {
            throw new \InvalidArgumentException('Invalid BankId', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }

}
