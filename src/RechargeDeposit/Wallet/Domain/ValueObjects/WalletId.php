<?php

namespace Src\RechargeDeposit\Wallet\Domain\ValueObjects;

class WalletId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function validate(): void
    {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('invalid wallet id', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
