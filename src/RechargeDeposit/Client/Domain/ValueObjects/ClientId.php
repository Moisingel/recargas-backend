<?php

namespace Src\RechargeDeposit\Client\Domain\ValueObjects;

class ClientId
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
            throw new \InvalidArgumentException('invalid client id', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
