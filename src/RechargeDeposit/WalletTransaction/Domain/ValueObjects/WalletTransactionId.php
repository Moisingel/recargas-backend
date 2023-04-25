<?php

namespace Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects;

class WalletTransactionId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function validate(): void
    {
        if ($this->value < 0) {
            throw new \InvalidArgumentException('Invalid Wallet Transaction Id', 400);
        }
    }

    public function value(): int
    {
        return $this->value;
    }




}
