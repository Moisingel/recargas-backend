<?php

namespace Src\RechargeDeposit\Bank\Domain\ValueObjects;

class BankName
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if (strlen($this->value) < 3) {
            throw new \InvalidArgumentException('Invalid BankName', 400);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

}
