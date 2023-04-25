<?php

namespace Src\RechargeDeposit\Promoter\Domain\ValueObjects;

class PromoterId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate()
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('Invalid promoter id', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
