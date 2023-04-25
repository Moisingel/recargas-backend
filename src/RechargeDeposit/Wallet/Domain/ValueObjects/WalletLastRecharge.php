<?php

namespace Src\RechargeDeposit\Wallet\Domain\ValueObjects;

class WalletLastRecharge
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function validate(): void
    {
        //validate date
        if (strlen($this->value) !== 10) {
            throw new \InvalidArgumentException('invalid wallet last recharge', 400);
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
