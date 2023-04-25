<?php

namespace Src\RechargeDeposit\Promoter\Domain\ValueObjects;

class PromoterName
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate()
    {
        if (empty($this->value)) {
            throw new \InvalidArgumentException('Invalid promoter name', 400);
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
