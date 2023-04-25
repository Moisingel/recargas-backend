<?php

namespace Src\RechargeDeposit\WalletTransaction\Domain\ValueObjects;

class WalletTransactionAmount
{
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
