<?php

namespace Src\RechargeDeposit\Client\Domain\ValueObjects;

class ClientName
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if (empty($this->value)) {
            throw new \InvalidArgumentException('invalid client name', 400);
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
