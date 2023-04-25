<?php

namespace Src\RechargeDeposit\Channel\Domain\ValueObjects;

class ChannelName
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if (strlen($this->value) < 2) {
            throw new \InvalidArgumentException("Invalid name", 400);
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
