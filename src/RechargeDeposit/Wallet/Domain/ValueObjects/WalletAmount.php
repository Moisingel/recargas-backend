<?php

namespace Src\RechargeDeposit\Wallet\Domain\ValueObjects;

class WalletAmount
{
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function validate(): void
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('invalid wallet amount', 400);
        }
    }

    public function value(): float
    {
        return $this->value;
    }

}
